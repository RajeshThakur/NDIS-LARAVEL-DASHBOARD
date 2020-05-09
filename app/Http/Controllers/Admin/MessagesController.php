<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Dmark\Messenger\Models\Message;
use Dmark\Messenger\Models\Participant;
use Dmark\Messenger\Models\Thread;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreMessageRequest;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\DB;



use Illuminate\Notifications\Notifiable;
use App\Notifications\MessageSent;

class MessagesController extends Controller
{

    use Notifiable;
    /**
     * Show all of the message threads to the user.
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        // $users = DB::table('messages')->where('body', 'LIKE', "%neq%")->get();
        // dd($users);
        abort_unless(\Gate::allows('message_access'), 403);

        // $query='';
        // if( isset( $request->q ) ){
        //     $query = $request->query('q');
        //     // dd($query);
        //     $threads = DB::table('messages')->where('body', 'LIKE', "%$query%")->get();
        //     $threads = DB::table('messages')->where('body', 'LIKE', "%$query%")->get();

        //     // dd($threads);

        //     $size = sizeof($threads);
        //     $result = 'result';
        //     if( $size > 1) $result = 'results';
        //     $msg = "Found <b>'" .$size ."'</b> ". $result." for your query of <b>'" .$request->q ."'</b>";
        //     $threads->search = array( 'messages'=>$msg);
        //     // dd($threads->search);
        // }
        // else
        //     $threads = Thread::forUser(Auth::id())->latest('updated_at')->get();
            // dd($threads);

            

        $user = User::find(Auth::id());

        if( isset( $request->q ) && trim($request->q) != ''){
            $threads = Thread::getBySubject( trim($request->q) );
            return view('admin.messenger.index', compact('threads'));
        }
        

        foreach ($user->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
        // All threads, ignore deleted/archived participants
        // $threads = Thread::getAllLatest()->get();
        $unread = newMessages()->pluck('id');

        // All threads that user is participating in
        $threads = Thread::forUser(Auth::id())->latest('updated_at')->get();

        // All threads that user is participating in, with new messages
        // $threads = Thread::forUserWithNewMessages(Auth::id())->latest('updated_at')->get();

        return view('admin.messenger.index', compact('threads', 'unread'));
    }

    /**
     * Shows a message thread.
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        abort_unless(\Gate::allows('message_show'), 403);

        try {
            
            $thread = Thread::with('participants')->findOrFail($id);
            // $thread->load('participants');
            //dd($thread);
            // $arrayOfId = $thread->participants->toArray();
            
            // $record_map = array_map(function($record){

            //     if($record['user_id']){
            //         return User::where('id',$record['user_id'])->first()->toArray();
            //     }else   
            //         return false;
                
            // }, $arrayOfId);
            
            // foreach($record_map as $value){
            //     if(is_array($value)){
            //         $replyTo = $value;
            //     }
            // }
            
            $replyTo = User::find(($thread->participants)->whereNotIn('user_id',[Auth::id()])->pluck('user_id')[0]);

        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');

            return redirect()->route('admin.messages.index');
        }

        // show current user in list if not a current participant
        // $users = User::whereNotIn('id', $thread->participantsUserIds())->get();

        // don't show the current user in list
        $userId = Auth::id();
       
        $users = User::whereNotIn('id', $thread->participantsUserIds($userId))->get();

        $thread->markAsRead($userId);
        
        return view('admin.messenger.show', compact('thread', 'users', 'replyTo'));
    }

    /**
     * Creates a new message thread.
     *
     * @return mixed
     */
    public function create()
    {
        abort_unless(\Gate::allows('message_create'), 403);

        $users = User::where('id', '!=', Auth::id())->get();

        $users->messagables = Message::getMessagable()->mapWithKeys(function ($value, $key) {  
            if($value->id != Auth::id())          
                return [$value->id => $value->first_name .' '.$value->last_name .' ('. $value->email.')' ];
        })->toArray();
        
        // pr($users->messagables,1);

        return view('admin.messenger.create', compact('users'));
    }

    /**
     * Stores a new message thread.
     *
     * @return mixed
     */
    public function store( StoreMessageRequest $request )
    {
        abort_unless(\Gate::allows('message_create'), 403);

        $input = Input::all();

        $thread = Thread::create([
            'subject' => $input['subject'],
        ]);

        // Message
        $msg = Message::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'body' => $input['message'],
        ]);

        // Sender
        $sender = Participant::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'last_read' => new Carbon,
        ]);

        // Recipients
        if (Input::has('recipients')) {
            $thread->addParticipant($input['recipients']);
        }

        $user = \App\User::find($input['recipients']);
        // $user = \App\User::find(Auth::id());
        // pr($input['recipients'],1);
        $user->notify(new MessageSent($msg->toArray()));

        // pr($user ,1);

        return redirect()->route('admin.messages.index')->with('success', trans('msg.inbox_message_add.success'));
    }

    /**
     * Adds a new message to a current thread.
     *
     * @param $id
     * @return mixed
     */
    public function update($id)
    {
        abort_unless(\Gate::allows('message_edit'), 403);
        
        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');

            return redirect()->route('admin.messages.index');
        }

        $thread->load('participants');

        $thread->activateAllParticipants();
       
        // dd($thread->toArray());

        // Message
        $msg = Message::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'body' => Input::get('message'),
        ]);

        // Add replier as a participant
        $participant = Participant::firstOrCreate([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
        ]);
        $participant->last_read = new Carbon;
        $participant->save();

        // Recipients
        if (Input::has('recipients')) {
            $thread->addParticipant(Input::get('recipients'));
        }

        //send notification
        ($thread->participants)->map(function ($item, $key) use ($msg){
            if( $item->user_id !=  Auth::id()):
                $user = \App\User::find($item->user_id);
                // pr($user, 1);
                if($user->id)
                    $user->notify(new MessageSent($msg->toArray()));
            endif;
        });
       

        return redirect()->route('admin.messages.show', $id)->with('success', 'Message sent');;
    }
}

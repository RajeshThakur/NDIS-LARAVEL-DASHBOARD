<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreMessageRequest;

use Carbon\Carbon;
use App\User;

use Dmark\Messenger\Models\Message;
use Dmark\Messenger\Models\Participant;
use Dmark\Messenger\Models\Thread;

use App\Notifications\MessageSent;
use Illuminate\Notifications\Notifiable;



class MessagesApiController extends Controller
{
    use Notifiable;
    
    /**
     * Fetch and return all messages
     *
     * @return mixed user messages with thread_id,subject,created_at
     * 
     */
    public function list()
    {
        // abort_unless(\Gate::allows('message_access'), 403);
        // $user = User::find(Auth::id());
        // foreach ($user->unreadNotifications as $notification) {
        //     $notification->markAsRead();
        // }
       
        // All threads that user is participating in
        try {
            $threads = Thread::forUser(Auth::id())->latest('message_thread.updated_at')
                                                ->select(
                                                            'message_thread.id as thread_id',
                                                            'message_thread.subject as subject',
                                                            'message_thread.created_at'
                                                            // 'message_thread.updated_at'
                                                    )
                                                ->get();
            return response()->json(['status'=>false,'thread'=>$threads], 200);

        } catch(ModelNotFoundException $exception) {
            
            \Log::critical( [ 'Message' => $exception->getMessage(), 'file' => $exception->getFile(), 'line'=>$exception->getLine() ] );

            return response()->json(['status'=>false, 'message'=>'Sorry, Please try agin '], 400);
        }
        catch(Exception $exception) {
            
            \Log::critical( [ 'Message' => $exception->getMessage(), 'file' => $exception->getFile(), 'line'=>$exception->getLine() ] );

            return response()->json(['status'=>false, 'message'=>'Sorry, Please try agin '], 400);
        }
        

    }


    /**
     * Fetch a single thread
     *
     * @param string $id
     * @return mixed message data
     * 
     */
    public function singleThread($id, Request $request)
    {
        try {
            $thread = Thread::findOrFail($id);
            $userId = Auth::id();
            $thread->markAsRead($userId);
            $apiMsg = [];
            ($thread->messages)->each(function ($item, $key) use (&$apiMsg){      
                $apiMsg[$key]['id'] = $item->id;
                $apiMsg[$key]['user_name'] = User::where('id',$item->user_id)->get()->reduce(function ($carry, $item) {
                                                return $item->first_name ." ".$item->last_name;
                                            });
                $apiMsg[$key]['message'] = $item->body;
            });
            // dd($apiMsg);
            // return $thread;
            // return $thread->subject;
            // return $thread->messages;
            return response()->json(['status'=>true,'thread_id'=>$thread->id,'subject'=>$thread->subject,'messages'=>$apiMsg], 200);

        } catch (ModelNotFoundException $e) {

            \Log::critical( [ 'Message' => $e->getMessage(), 'file' => $e->getFile(), 'line'=>$e->getLine() ] );
            return response()->json(['status'=>false,'error'=>'The thread was not found.'], 400);
        }
        catch(Exception $exception) {
            \Log::critical( [ 'Message' => $exception->getMessage(), 'file' => $exception->getFile(), 'line'=>$exception->getLine() ] );
            return response()->json(['status'=>false, 'message'=>'Sorry, Please try agin '], 400);
        }
    }


    /**
     * comment in a thread
     *
     * @param object Request
     * @return mixed 
     * 
     */
    public function addComment(Request $request)
    {
        $messages = [
            'thread_id.required' => 'No thread id found!',
            'message.required' => 'Message cannot be blank!',
        ];
        $data = Validator::make($request->all(),[
            'thread_id' => 'required',           
            'message' => 'required'
        ], $messages);
        
        //return error if any field is missing
        if($data->fails()):
            return response()->json(['status'=>false,'error'=>$data->messages()], 400);
        endif;
        

        
        try {
            $user_id = Auth::id();
            $thread = Thread::findOrFail($request['thread_id']);
            
            //return if dont belong to this thread
            if ( !in_array( $user_id, $thread->participantsUserIds() ) ):
                return response()->json(['status'=>false,'error'=>'User don\'t belong to this message thread'], 400);
            endif;

            //We don't need to activate all the participants for the message
            // $thread->activateAllParticipants();

            // Message 
            $msg = Message::create([
                'thread_id' => $thread->id,
                'user_id' => $user_id,
                'body' => trim($request['message']),
            ]);
            
            $thread->load('participants');

            // $msgParticipants = $thread->participants();
            // $_msg_participants = $thread->participants->pluck('user_id')->toArray();
            $_msg_participants = $thread->participants->filter(function ($value, $key) use($user_id){
                return $value['user_id']!=$user_id;
            })->pluck('user_id')->toArray();

            $msgParticipants = \App\User::whereIn('id', $_msg_participants)->get();
            foreach($msgParticipants as $msgParticipant){
                $msgParticipant->notify(new MessageSent($msg->toArray()));
            }
            
            // pr($_msg_participants, 1);
    
            // // Add replier as a participant
            // $participant = Participant::firstOrCreate([
            //     'thread_id' => $thread->id,
            //     'user_id' => $user_id,
            // ]);
            
            // $participant->last_read = new Carbon;
            // $participant->save();
    
            // Recipients
            // if (Input::has('recipients')) {
            //     $thread->addParticipant(Input::get('recipients'));
            // }
    
            return response()->json(['status'=>true,'thread_id'=>$thread->id,'message_id'=>$msg->id], 200);

        }
        catch (ModelNotFoundException $e) {
            \Log::critical( [ 'Message' => $e->getMessage(), 'file' => $e->getFile(), 'line'=>$e->getLine() ] );
            return response()->json(['status'=>false,'msg'=>'The comment cannot be added. Please try again','error'=>$e->getMessage()], 400);
        }
        catch(Exception $exception) {
            \Log::critical( [ 'Message' => $exception->getMessage(), 'file' => $exception->getFile(), 'line'=>$exception->getLine() ] );
            return response()->json(['status'=>false,'msg'=>'The comment cannot be added. Please try again','error'=>$e->getMessage()], 400);
        }
    }


    /**
     * Create a new thread
     *
     * @param object Request
     * @return mixed 
     * 
     */
    public function createThread(Request $request)
    {
        $messages = [
            'message_to.required' => 'Please select a message recipient!',
            'message_subject.required' => 'Message subject cannot be blank!',
            'message_body.required' => 'Message body cannot be blank!',
        ];
        $data = Validator::make($request->all(),[
            'message_to' => 'required',            
            'message_subject' => 'required',
            'message_body' => 'required'

        ], $messages);
        // dd($data->messages());
        //return error if any field is missing
        if($data->fails())return response()->json(['status'=>false,'error'=>$data->messages()], 400);

        try{
            $input = Input::all();
              
            $thread = Thread::create([
                'subject' => $input['message_subject'],
            ]);
    
            // Message
            $msg = Message::create([
                'thread_id' => $thread->id,
                'user_id' => Auth::id(),
                'body' => $input['message_body'],
            ]);
    
            // Sender
            $sender = Participant::create([
                'thread_id' => $thread->id,
                'user_id' => Auth::id(),
                'last_read' => new Carbon,
            ]);
    
            // Recipients
            if (Input::has('message_to')) {
                $thread->addParticipant($input['message_to']);
            }
    
            // pr($msg,1);
    
            $user = \App\User::find($input['message_to']);
            // $user = \App\User::find(Auth::id());
            // pr($input['recipients'],1);
            $user->notify(new MessageSent($msg->toArray()));

            return response()->json(['status'=>true,'thread_id'=>$msg->id], 200);
            
        }
        catch (ModelNotFoundException $e) {
            \Log::critical( [ 'Message' => $e->getMessage(), 'file' => $e->getFile(), 'line'=>$e->getLine() ] );

            return response()->json(['status'=>false,'error'=>$e->messages()], 400);
        }
        catch(Exception $exception) {
            \Log::critical( [ 'Message' => $exception->getMessage(), 'file' => $exception->getFile(), 'line'=>$exception->getLine() ] );
            return response()->json(['status'=>false,'error'=>$e->messages()], 400);
        }

    
       
       
    }

    /**
     * Get all messagable users for the current user
     *
     * @param object Request
     * @return mixed 
     * 
     */
    public function getMessagable()
    {
        $users = User::where('id', '!=', Auth::id())->get();

        // Message::getMessagable();
        $messagable = Message::getMessagable();
        // dd($messagable);
        $users->messagable = collect();
        if( $messagable->isEmpty() ):
            return response()->json(['status'=>false,'message'=>'No user available'], 400);
        else:
            $users->messagable = $messagable->mapWithKeys(function ($value, $key) {
                return array($key=>[  
                          'user_id' => $value->id,
                          'first_name' => $value->first_name,
                          'last_name' => $value->last_name,
                          'email' =>$value->email,
                          'role' => \App\Role::whereId($value->role_id)->pluck('title')
                        ]);
            })->toArray();
            // dd($users->messagable);
            return response()->json(['status'=>true,'users'=>$users->messagable], 400);
        endif;
    }


    /**
     * Search messages 
     *
     * @return mixed messages list
     * 
     */
    public function searchMessage( Request $request )
    {
        $threads = Thread::where('subject', 'like', '%'.$request->q.'%')
                            ->select(
                                    'message_thread.id as thread_id',
                                    'message_thread.subject as subject',
                                    'message_thread.created_at'
                                    // 'message_thread.updated_at'
                                )
                            ->get();

        return response()->json(['status'=>true,'messages'=>$threads], 400);

    }
}

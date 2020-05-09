<?php

namespace Dmark\Messenger\Traits;

use Dmark\Messenger\Models\Message;
use Dmark\Messenger\Models\Models;
use Dmark\Messenger\Models\Participant;
use Dmark\Messenger\Models\Thread;
use Illuminate\Database\Eloquent\Builder;

trait Messagable
{
    /**
     * Message relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * @codeCoverageIgnore
     */
    public function messages()
    {
        return $this->hasMany(Models::classname(Message::class));
    }

    /**
     * Participants relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * @codeCoverageIgnore
     */
    public function participants()
    {
        return $this->hasMany(Models::classname(Participant::class));
    }

    /**
     * Thread relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     *
     * @codeCoverageIgnore
     */
    public function threads()
    {
        return $this->belongsToMany(
            Models::classname(Thread::class),
            Models::table('participants'),
            'user_id',
            'thread_id'
        );
    }

    /**
     * Returns the new messages count for user.
     *
     * @return int
     */
    public function newThreadsCount()
    {
        return $this->threadsWithNewMessages()->count();
    }

    /**
     * Returns the new messages count for user.
     *
     * @return int
     */
    public function unreadMessagesCount()
    {
        return Message::unreadForUser($this->getKey())->count();
    }

    /**
     * Returns all threads with new messages.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function threadsWithNewMessages()
    {
        return $this->threads()
            ->where(function (Builder $q) {
                $q->whereNull(Models::table('message_participants') . '.last_read');
                $q->orWhere(Models::table('message_thread') . '.updated_at', '>', $this->getConnection()->raw($this->getConnection()->getTablePrefix() . Models::table('message_participants') . '.last_read'));
            })->get();
    }


    /**
     * Sends the Message to one/multiple Users
     *
     * @param string                              $subject
     * @param string                              $body
     * @param \App\User                           $from_id
     * @param \App\User                           $to User Id's
     *
     * @return array
     */
    public function sendMessage( $subject, $body, $from_id, $to=[] )
    {
        // Thread
        $thread = Thread::create([
            'subject' => $subject,
        ]);

        // Message
        $msg = Message::create([
            'thread_id' => $thread->id,
            'user_id' => $from_id,
            'body' => $body
        ]);

        // Add sender as recipient as well
        $thread->addParticipant($from_id);

        // Recipients
        foreach($to as $recepient){
            $thread->addParticipant($recepient);
        }

        return [ 'message_id'=>$msg->id, 'thread_id'=>$thread->id ];

    }


    /**
     * Sends the Message to one/multiple Users
     *
     * @param string                              $subject
     * @param string                              $body
     * @param \App\User                           $from_id
     * @param \App\User                           $to User Id's
     * @param \Dmark\Messenger\Models\Thread      $thread_id Message Thread Id ( optional )
     *
     * @return array
     */
    public function sendThreadMessage( $subject, $body, $from_id, $to=[], $thread_id = 0 )
    {
        try{
            if(!$thread_id){
                $thread = Thread::create([
                    'subject' => $subject,
                ]);
            }else{
                $thread = Thread::findorfail($thread_id);
            }
        }
        catch(Exception $ex){
            throw("Thread not found!");
        }
        
        try{

            // Message
            $msg = Message::create([
                'thread_id' => $thread->id,
                'user_id' => $from_id,
                'body' => $body
            ]);

            // Add sender as recipient as well
            $thread->addParticipant($from_id);

            // Recipients
            foreach($to as $recepient){
                $thread->addParticipant($recepient);
            }

        }
        catch(Exception $ex){
            throw("Unable to add Message!");
        }

        return [ 'message_id'=>$msg->id, 'thread_id'=>$thread->id ];

    }


}

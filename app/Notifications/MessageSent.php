<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Broadcasting\MobileChannel;

class MessageSent extends Notification implements ShouldQueue
{
    use Queueable;

    protected $data;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $arr)
    {
        $this->queue = 'notifications';
        $this->data = $arr;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database', MobileChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // pr($this->data,1);
        return (new MailMessage)
                    ->subject('['.config('app.name').'] New Message Received!')
                    ->view('mail.messageSent', ['data' => $this->data]);
                    // ->line('You have an unread message.')
                    // ->line($this->data['thread']['subject'])
                    // ->action('Check the message',  route("admin.messages.show", [$this->data['thread_id'] ]) )
                    // ->line('Thank you for using '.config('app.name').'!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'subject' =>  $this->data['thread']['subject'],
            'body'    =>  $this->data['body']
        ];
    }


     /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'link'=>route("admin.messages.show", [$this->data['thread_id'] ]),
            'text'=> 'You have received a new message!',
            'details'=>$this->data['body']
        ];
    }


    /**
     * send the notification to the Mobile App if User is registered
     *
     * @param  mixed  $notifiable
     */
    public function toMobile($notifiable){

        if($notifiable->push_token){
            \OneSignal::sendNotificationToUser(
                $this->data['body'],
                $notifiable->push_token,
                $url = null,
                $data = null,
                $buttons = [
                    ["id"=>$this->data['thread_id'], "text"=> "Reply", "icon"=>"ic_menu_send"]
                ],
                $schedule = null,
                $headings = 'You have received a new message!',
                $subtitle = null
            );
        }
    }

    
}

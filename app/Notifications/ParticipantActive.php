<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Broadcasting\MobileChannel;

class ParticipantActive extends Notification implements ShouldQueue
{
    use Queueable;
    protected $participantUser;
    /**
     * Create a new notification instance.
     *
     * @param $user
     * @return void
     */
    public function __construct($data)
    {
        $this->queue = 'notifications';
        $this->participantUser = $data;
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
        return (new MailMessage)
            ->subject('['.config('app.name').'] Partcipant is activated!')
            ->view('mail.participantActive', ['participantUser' => $this->participantUser, 'notifiable' => $notifiable]);
            // ->greeting( sprintf('Hi %s,', $notifiable->getName() ) )
            // ->line( sprintf( 'Participant %s\'s account is active now!', $this->participantUser->getName() ) )
            // // ->action('Activate', route('activate', [$this->data->token]))
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
            //
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
            'link'=> route('admin.participants.edit',[$this->participantUser->participant->id]),
            'text'=> sprintf('Participant %s is active!', $this->participantUser->getName() ),
            'details'=>'Participant has recently activated his account. Now participant onboarding process can be initiated!'
            // 'details'=>$this->participantUser
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
                'Participant has recently activated his account. Now participant onboarding process can be initiated!',
                $notifiable->push_token,
                $url = null,
                $data = null,
                $buttons = null,
                $schedule = null,
                $headings = sprintf('Participant %s is active!', $this->participant->getName() ),
                $subtitle = null
            );
        }
    }

}

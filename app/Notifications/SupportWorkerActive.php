<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Broadcasting\MobileChannel;

class SupportWorkerActive extends Notification implements ShouldQueue
{
    use Queueable;
    protected $swUser;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->queue = 'notifications';
        $this->swUser = $data;
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
            ->subject('['.config('app.name').'] Support Worker is activated!')
            ->view('mail.supportWorkerActive', ['swUser' => $this->swUser, 'notifiable' => $notifiable]);
                // ->greeting(sprintf('Hi %s,', $notifiable->getName() ))
                // ->line(sprintf('Support Worker %s\'s account is active now!', $this->swUser->getName()))
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
            'link'=> route('admin.support-workers.edit',[$this->swUser->id]),
            'text'=> sprintf('Support Worker %s is active!', $this->swUser->getName() ),
            'details'=>'Support Worker has recently activated his account. Now Support Worker onboarding process can be initiated!'
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
                'Support Worker has recently activated his account. Now Support Worker onboarding process can be initiated!',
                $notifiable->push_token,
                $url = null,
                $data = null,
                $buttons = null,
                $schedule = null,
                $headings = sprintf('Support Worker %s is active!', $this->swUser->getName() ),
                $subtitle = null
            );
        }
    }


}

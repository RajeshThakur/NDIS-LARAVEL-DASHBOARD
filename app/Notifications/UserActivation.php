<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Broadcasting\MobileChannel;

class UserActivation extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    /**
     * Create a new notification instance.
     *
     * @param $user
     * @return void
     */
    public function __construct($user)
    {
        $this->queue = 'notifications';
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
            ->subject('['.config('app.name').'] Activate Your Account!')
            ->view('mail.userActivation', ['user' => $this->user, 'notifiable' => $notifiable]);
            // ->greeting(sprintf('Hi %s,', $notifiable->getName() ) )
            // ->line('Your account has been created. You will need to activate your account to sign in into this account.')
            // ->action('Activate', route('activate', [$this->user->token]))
            
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
    
    
    
}

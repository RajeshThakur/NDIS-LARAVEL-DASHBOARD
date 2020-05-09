<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Broadcasting\MobileChannel;

class GuardianActivation extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->queue = 'notifications';
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
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
                    ->subject('['.config('app.name').'] Activate Your Guardian Account')
                    ->view('mail.guardianActivation', ['notifiable' => $notifiable]);
                    // ->greeting(sprintf('Hi %s,', $notifiable->name))
                    // ->line('You have been added as Guardian for '.$notifiable->user->getName() )
                    // ->line('In order to start using your account you need to activate your account and create a password.' )
                    // ->action('Activate', route('activate-advocate', [$notifiable->token]))
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
            'link'=>'#',
            'text'=>"You have been added as guardian for participant ".$notifiable->user->getName(),
            'details'=>"Participant ".$notifiable->user->getName()." have added you as guardian to perform duties as his representative on ".config('app.name')
        ];
    }


}

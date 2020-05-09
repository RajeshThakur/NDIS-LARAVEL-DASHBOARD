<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DocumentUploaded extends Notification implements ShouldQueue
{
    use Queueable;

    protected $data;  
    protected $user;  
    protected $role;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( array $data)
    {
        $this->queue = 'notifications';
        $this->data = $data;
        $this->user = \App\User::find($data['user']);
        $this->role = ($this->user)->roles()->first()->title;
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
                ->subject('['.config('app.name').'] A document is uploaded !')
                ->view('mail.documentUploaded', ['data' => $this->data, 'role' => $this->role, 'user' => $this->user]);
                // ->line( $this->data['title'] . ' has been uploaded by '. $this->role . ' ' . $this->user->getName() )
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
            'subject' =>  "Document uploaded",
            'body'    =>  $this->data['title'] . ' has been uploaded by '. $this->role . ' ' . $this->user->getName()
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
            'subject' =>  "Document uploaded",
            'body'    =>  $this->data['title'] . ' has been uploaded by '. $this->role . ' ' . $this->user->getName()
        ];
    }
}

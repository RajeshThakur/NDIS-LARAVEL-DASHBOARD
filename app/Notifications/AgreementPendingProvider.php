<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Broadcasting\MobileChannel;

class AgreementPendingProvider extends Notification implements ShouldQueue
{
    use Queueable;

    protected $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($opform)
    {
        $this->queue = 'notifications';
        $this->data = $opform;
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
                    ->subject('['.config('app.name').' ] Service Agreement Pending Signature!' )
                    ->view('mail.agreementPendingProvider', ['data' => $this->data, 'notifiable' => $notifiable]);
                    // ->greeting(sprintf('Hi %s,', $notifiable->getName() ))
                    // ->line('There are pending agreements that needs your signatures.')
                    // ->line('In order to get these participants/support workers started, we need these agreements finished and signed up!')
                    // ->line('You can sign this form by looging into the Provider Portal')
                    // ->action('Sign Agreement Now', route('admin.events.show', [$this->data['id']]) )
                    // ->line('Thank you for using our application!');
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
            'link'=>route("admin.forms.create", [11, $notifiable->user_id ]),
            'text'=> 'Service Agreement needs to be signed!',
            'details'=>"Your Service Agreement signing is pending. We cannot get participants/support workers started without signing."
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
                "Your Service Agreement signing is pending. We cannot get participants/support workers started without signing.",
                $notifiable->push_token,
                $url = null,
                $data = null,
                $buttons = [
                    ["id"=>$this->data['thread_id'], "text"=> "Sign Agreement", "icon"=>"ic_menu_send"]
                ],
                $schedule = null,
                $headings = 'Service Agreement needs to be signed!',
                $subtitle = null
            );
        }
    }


}

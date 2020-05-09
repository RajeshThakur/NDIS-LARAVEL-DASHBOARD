<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Broadcasting\MobileChannel;

class AgreementPendingParticipant extends Notification implements ShouldQueue
{
    use Queueable;
    protected $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->queue = 'notifications';
        $this->data = $data;
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
                    ->view('mail.agreementPendingParticipant', ['data' => $notifiable]);
                    // ->greeting(sprintf('Hi %s,', $notifiable->getName() ))
                    // ->line('You have recently signed up with '.config('app.name').'. We are looking forward to sign the Service Agreement with you.' )
                    // ->line('We cannot get you started with no service agreement signed. In order to sign the service agreement, please login to our Mobile App and sign the agreement.')
                    // ->line('If you haven\'t already downloaded our mobile app, you can download from the links below.')
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
            'details'=>"Your Service Agreement signing is pending. We cannot get you started with no service agreement signed"
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
                "Your Service Agreement signing is pending. We cannot get you started with no service agreement signed",
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

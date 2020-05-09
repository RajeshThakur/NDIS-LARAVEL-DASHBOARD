<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Broadcasting\MobileChannel;

class MessageForBooking extends Notification implements ShouldQueue
{
    use Queueable;

    protected $subject;
    protected $message;
    protected $sender;
    protected $booking_order_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $subject, $message, $sender, $booking_order_id )
    {

        $this->queue = 'notifications';
        $this->subject = $subject;
        $this->message = $message;
        $this->sender = $sender;
        $this->booking_order_id = $booking_order_id;
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

        if( $notifiable->roles()->get()->contains( config('ndis.support_worker_role_id') ) )
            $_link = route("admin.bookings.edit.contact.worker", [$this->booking_order_id]);

        if( $notifiable->roles()->get()->contains( config('ndis.participant_role_id') ) )
            $_link = route("admin.bookings.edit.contact.participant", [$this->booking_order_id]);

        return (new MailMessage)
            ->subject('['.config('app.name').' - New Message on Booking ] '.$this->subject)
            ->view('mail.messageForBooking', ['notifiable' => $notifiable, 'link' => $_link]);
            // ->greeting(sprintf('Hi %s,', $notifiable->getName() ))
            // ->line("You have received a new Message for Booking")
            // ->action('View Message', $_link );
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
        $_link = "";
        if( $notifiable->roles()->get()->contains( config('ndis.support_worker_role_id') ) )
            $_link = route("admin.bookings.edit.contact.worker", [$this->booking_order_id]);

        if( $notifiable->roles()->get()->contains( config('ndis.participant_role_id') ) )
            $_link = route("admin.bookings.edit.contact.participant", [$this->booking_order_id]);


        return [
            'link'=>$_link,
            'text'=> 'You have received a new message on Service Booking',
            'details'=>$this->message
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
                'You have received a new message on Service Booking',
                $notifiable->push_token,
                $url = null,
                $data = null,
                $buttons = null,
                // $buttons = [
                //     ["id"=>$this->booking_order_id, "text"=> "View Message", "icon"=>"ic_menu_send"]
                // ],
                $schedule = null,
                $headings = null,
                $subtitle = null
            );
        }
    }


}

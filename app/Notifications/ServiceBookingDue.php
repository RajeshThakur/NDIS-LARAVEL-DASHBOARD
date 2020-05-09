<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Broadcasting\MobileChannel;


class ServiceBookingDue extends Notification implements ShouldQueue
{
    use Queueable;

    protected $booking_order;
    protected $time;
    protected $line;
    protected $item;
    protected $participant;
    protected $worker;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $booking_order, $time, $for )
    {
        $this->queue = 'notifications';
        $this->booking_order = $booking_order;
        $this->time = $time;
        $this->item = \App\RegistrationGroup::find($booking_order->booking->item_number);
        $this->worker = \App\User::find($booking_order->booking->supp_wrkr_ext_serv_id);
        $this->participant = \App\User::find($booking_order->booking->participant_id);

        if( $for == 'participant' ){
            if( $time == 'day' )
                $this->line = "Confirmation for tomorrow’s Service Booking for " . $this->item->title . " with Support Worker " . $this->worker->getName() . " at " .dbDateToTime($this->booking_order->starts_at). " on the " . dbToDate($this->booking_order->starts_at);
            if( $time == 'hour' )
                $this->line = "In 1 hour the Service Booking for " . $this->item->title . " with Support Worker " . $this->worker->getName() . " at " .dbDateToTime($this->booking_order->starts_at). " will commence";
            if( $time == 'now' )
                $this->line = "Your Service Booking for " . $this->item->title . " with Support Worker " . $this->worker->getName() . " is now due";
        }

        if( $for == 'worker' ){
            if( $time == 'day' )
                $this->line = "Confirmation for tomorrow’s Service Booking for " . $this->item->title . " with Participant " . $this->participant->getName() . " at " .dbDateToTime($this->booking_order->starts_at). " on the " . dbToDate($this->booking_order->starts_at);
            if( $time == 'hour' )
                $this->line = "In 1 hour the Service Booking for " . $this->item->title . " with Participant " . $this->participant->getName() . " at " .dbDateToTime($this->booking_order->starts_at). " will commence";
            if( $time == 'now' )
                $this->line = "Your Service Booking for " . $this->item->title . " with Participant " . $this->participant->getName() . " is now due";
        }
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
                ->subject(config('app.name').' - Service booking is due' )
                ->view('mail.serviceBookingCreated', ['line' => $this->line, 'notifiable' => $notifiable]);
                //->greeting(sprintf('Hi %s,', $notifiable->getName() ))
                // ->line( $this->line )
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
            // 'link'=>"",
            // 'text'=>"Service booking is due",
            // 'details'=>$this->line
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
                $this->line,
                $notifiable->push_token,
                $url = null,
                $data = null,
                $buttons = null,
                // $buttons = [
                //     ["id"=>$this->data['id'], "text"=> "View Event", "icon"=>"ic_menu_send"]
                // ],
                $schedule = null,
                $headings = "Service booking is due",
                $subtitle = null
            );
        }
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Broadcasting\MobileChannel;

class BookingIncidentReport extends Notification implements ShouldQueue
{
    use Queueable;

    protected $reporter;
    protected $incident;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $reporter, $incident )
    {
        $this->queue = 'notifications';
        $this->reporter = $reporter;
        $this->incident = $incident;
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
                    ->subject('['.config('app.name').' - Service Booking] New Incident Reported by '.$this->reporter->getName()."!")
                    ->view('mail.bookingIncidentReport', ['incident' => $this->incident, 'notifiable' => $notifiable, 'reporter' => $this->reporter ] );
                    // ->greeting(sprintf('Hi %s,', $notifiable->getName() ))
                    // // ->line('A new incident has been reported on, One of your Service Booking. Click the link below to view the Service Booking:')
                    // ->line(  $this->reporter->getName() . ' has submitted an Incident Log on ' . dbToDate( $this->incident->created_at ) )
                    // ->action('View Incident', $this->incident->url)
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
            'link'=>route("admin.bookings.edit.incident", [$this->incident->booking_order_id]),
            'text'=>$this->reporter->getName() . ' has submitted an Incident Log on ' . dbToDate( $this->incident->created_at ) ,
            'details'=>'Incident is created for the Booking Order ID:'.$this->incident->booking_order_id
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
            'link'=>route("admin.bookings.edit.incident", [$this->incident->booking_order_id]),
            'text'=> $this->reporter->getName() . ' has submitted an Incident Log on ' . dbToDate( $this->incident->created_at ) ,
            'details'=>'Incident is created for the Booking Order ID:'.$this->incident->booking_order_id
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
                'Incident is created for the Booking Order ID:'.$this->incident->booking_order_id,
                $notifiable->push_token,
                $url = null,
                $data = null,
                $buttons =null,
                $schedule = null,
                $headings = $this->reporter->getName() . ' has submitted an Incident Log on ' . dbToDate( $this->incident->created_at ) ,
                $subtitle = null
            );
        }
    }
}

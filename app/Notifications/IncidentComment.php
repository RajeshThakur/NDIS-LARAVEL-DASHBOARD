<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Broadcasting\MobileChannel;

class IncidentComment extends Notification implements ShouldQueue
{
    use Queueable;

    protected $bookingOrder;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($bookingOrder)
    {
        $this->queue = 'notifications';
        $this->bookingOrder = $bookingOrder;
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
                    ->subject('['.config('app.name').'] New comment has been added to incident!')
                    ->view('mail.incidentComment', ['bookingOrder' => $this->bookingOrder, 'notifiable' => $notifiable]);
                    // ->greeting(sprintf('Hi %s,', $notifiable->getName() ))
                    // ->line('A new comment has been added to the incident involving service booking.')
                    // ->line('Details of the booking are below:')
                    // ->line('Service Booking Schedule On:' )
                    // ->line(' Date:' . \Carbon\Carbon::parse( $this->bookingOrder->starts_at )->format( config('panel.date_input_format') ) )
                    // ->line(' Starts At:' . \Carbon\Carbon::parse( $this->bookingOrder->starts_at )->format( config('panel.time_format') ) )
                    // ->line(' Ends At:' . \Carbon\Carbon::parse( $this->bookingOrder->ends_at )->format( config('panel.time_format') ) )
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
            'link'=>route("admin.bookings.edit.incident", [$this->bookingOrder->id]),
            'text'=>"A comment on Service Booking Incident has been made!",
            'details'=>"A new comment on the service booking incident has been made. You can view the Service Booking."
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
                "A new comment on the service booking incident has been made. You can view the Service Booking.",
                $notifiable->push_token,
                $url = null,
                $data = null,
                $buttons = null,
                $schedule = null,
                $headings = "A comment on Service Booking Incident has been made!",
                $subtitle = null
            );
        }
    }

}

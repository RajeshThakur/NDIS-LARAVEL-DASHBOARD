<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Broadcasting\MobileChannel;

use App\BookingOrderMeta;


class RescheduleBookingApproved extends Notification implements ShouldQueue
{
    use Queueable;
    protected $bookingOrder;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $bookingOrder )
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


        $orderMeta = BookingOrderMeta::getMetaVal( $this->bookingOrder->id, config('ndis.booking.reschedule.identifier') );

        return (new MailMessage)
                        ->subject('['.config('app.name').'] Service Booking Reschedule Approved!')
                        ->view('mail.rescheduleBookingApproved', ['orderMeta' => $orderMeta, 'notifiable' => $notifiable]);
                        // ->greeting(sprintf('Hi %s,', $notifiable->getName() ))
                        // ->line('Your Request for Service Booking Reschedule has been approved!')
                        // ->line('New Schedule for Service Booking is: ' )
                        // ->line(' Date:' . dbDatetimeToDate( $orderMeta['date'] ) )
                        // ->line(' Starts At:' . dbDatetimeToTime( $orderMeta['start_time'] ) )
                        // ->line(' Ends At:' . dbDatetimeToTime( $orderMeta['end_time'] ) )
                        // ->line('&nbsp;' )
                        // ->line('&nbsp;' )
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
            'link'=> route('admin.bookings.edit',[$this->bookingOrder->id]),
            'text'=> 'Booking Reschedule request is approved!',
            'details'=>'Your Booking Reschedule request is approved!'
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
                'Your request for booking reschedule has been approved!',
                $notifiable->push_token,
                $url = null,
                $data = null,
                $buttons = null,
                $schedule = null,
                $headings = 'Booking Reschedule request is approved!',
                $subtitle = null
            );
        }
    }
    
}

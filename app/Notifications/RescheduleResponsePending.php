<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Broadcasting\MobileChannel;

class RescheduleResponsePending extends Notification implements ShouldQueue
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

        $message = "";
        if( $this->bookingOrder->booking->participant_id == $orderMeta['initiated_by_id'] ){
            $message = 'There\'s a pending request for Service Booking Reschedule by ' . $this->bookingOrder->participant->getName() .'. Support Worker was suppose to respond to the request but haven\'t responded since past 24 hours.';
        }
        
        if( $this->bookingOrder->booking->supp_wrkr_ext_serv_id == $orderMeta['initiated_by_id'] ){
            $message = 'There\'s a pending request for Service Booking Reschedule by ' . $this->bookingOrder->supportWorker->getName() .'. You were suppose to respond to the request. Please review the request';
        }



        return (new MailMessage)
                    ->subject('['.config('app.name').'] - No Response on Service Booking Reschedule Request!')
                    ->view('mail.rescheduleResponsePending', ['bookingOrder' => $this->bookingOrder, 'message' => $message, 'orderMeta' => $orderMeta, 'notifiable' => $notifiable]);
                    // ->greeting(sprintf('Hi %s,', $notifiable->getName() ))
                    // ->line($message)
                    // ->line('Details of the booking are below:')
                    // ->line('Service Booking Schedule On:' )
                    // ->line(' Date:' . dbDatetimeToDate( $this->bookingOrder->starts_at ) )
                    // ->line(' Starts At:' . dbDatetimeToTime( $this->bookingOrder->starts_at ) )
                    // ->line(' Ends At:' . dbDatetimeToTime( $this->bookingOrder->ends_at ) )

                    // ->line('Requested to Rescheduled to:' )
                    // ->line(' Date:' . dbDatetimeToDate( $orderMeta['date'] ) )
                    // ->line(' Starts At:' . dbDatetimeToTime( $orderMeta['start_time'] ) )
                    // ->line(' Ends At:' . dbDatetimeToTime( $orderMeta['end_time'] ) )
                    // ->line('&nbsp;' )
                    // ->line('&nbsp;' )
                    // ->line('You can take appropariate action for the same using '.config('app.name'). ' web portal.' )

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
            'text'=> 'Booking Reschedule request is Pending!',
            'details'=>'A Booking Reschedule Request has been made, which isn\'t been responded from past 24 hours!'
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
                'A Booking Reschedule Request has been made, which isn\'t been responded from past 24 hours!',
                $notifiable->push_token,
                $url = null,
                $data = null,
                $buttons = null,
                $schedule = null,
                $headings = 'Booking Reschedule request is Pending!',
                $subtitle = null
            );
        }
    }

    
}

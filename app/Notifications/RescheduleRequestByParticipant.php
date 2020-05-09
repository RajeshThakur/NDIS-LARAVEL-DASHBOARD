<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Broadcasting\MobileChannel;

class RescheduleRequestByParticipant extends Notification  implements ShouldQueue
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
        $orderMeta = \App\BookingOrderMeta::getMetaVal( $this->bookingOrder->id, config('ndis.booking.reschedule.identifier') );

        if(!empty($orderMeta)){

                $participant = \App\User::find($this->bookingOrder->booking->participant_id);
                

                return (new MailMessage)
                    ->subject('['.config('app.name').'] Request to Reschedule Service Booking!')
                    ->view('mail.rescheduleRequestByParticipant', ['bookingOrder' => $this->bookingOrder, 'participant' => $participant, 'orderMeta' => $orderMeta, 'notifiable' => $notifiable]);

                    // ->greeting(sprintf('Hi %s,', $notifiable->getName() ))
                    // ->line('Participant ( '.$participant->getName().' ) of the Service Booking have requested to reschedule the service booking.')
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
                    // ->line('You can approve or decline the request using '.config('app.name'). ' mobile app.' )

                    // ->line('Thank you for using '.config('app.name').'!');

        }


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
            'bookingOrder' => $this->bookingOrder
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
            'text'=> 'New Request for Booking Reschedule!',
            'details'=>'You have received a new Booking Reschedule request!'
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
                'You have received a new Booking Reschedule request!',
                $notifiable->push_token,
                $url = null,
                $data = null,
                $buttons = null,
                $schedule = null,
                $headings = 'New Request for Booking Reschedule!',
                $subtitle = null
            );
        }
    }


}

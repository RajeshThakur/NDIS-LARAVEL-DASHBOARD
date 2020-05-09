<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Broadcasting\MobileChannel;

class RescheduleBookingDeclined extends Notification implements ShouldQueue
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

        // $orderMeta = BookingOrderMeta::getMetaVal( $this->bookingOrder->id, config('ndis.booking.reschedule.identifier') );
        return (new MailMessage)
                    ->subject('['.config('app.name').'] Service Booking Reschedule Declined!')
                    ->view('mail.rescheduleBookingDeclined', ['bookingOrder' => $this->bookingOrder, 'notifiable' => $notifiable]);
                    // ->greeting(sprintf('Hi %s,', $notifiable->getName() ))
                    // ->line('Your Requst for Service Booking Reshedule has been declined!')
                    // ->line('Service Booking Schedule remains as: ' )
                    // ->line(' Date:' . dbDatetimeToDate( $this->bookingOrder->starts_at ) )
                    // ->line(' Starts At:' . dbDatetimeToTime( $this->bookingOrder->starts_at ) )
                    // ->line(' Ends At:' . dbDatetimeToTime( $this->bookingOrder->ends_at ) )
                    // ->line('&nbsp;' )
                    // ->line('You can choose to keep the service booking or cancel it using '.config('app.name').' Mobile App!!')
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
            'text'=> 'Booking Reschedule request is declined!',
            'details'=>'Your Booking Reschedule request is declined, if you want you can cancel the Service Booking or can keep it as is!'
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
                'Your Booking Reschedule request is declined, if you want you can cancel the Service Booking or can keep it as is!',
                $notifiable->push_token,
                $url = null,
                $data = null,
                $buttons = null,
                // $buttons = [
                //     ["id"=>$this->data['id'], "text"=> "View Event", "icon"=>"ic_menu_send"]
                // ],
                $schedule = null,
                $headings = 'Booking Reschedule request is declined!',
                $subtitle = null
            );
        }
    }

}

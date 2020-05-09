<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Broadcasting\MobileChannel;

class ServiceBookingCancelConfirm extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $bookingOrder;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $bookingOrder, $user )
    {
        $this->queue = 'notifications';
        $this->bookingOrder = $bookingOrder;
        $this->user = $user;
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
                    ->subject('['.config('app.name').' - Service Booking] Service Booking Cancelled!')
                    ->view('mail.serviceBookingCancelConfirm', ['user' => $this->user, 'bookingOrder' => $this->bookingOrder]);
                    // ->greeting(sprintf('Hi %s %s,', $this->user->first_name, $this->user->last_name ) )
                    // ->line(sprintf('This is a confirmation email, that you have cancelled the following service booking:'))
                    // ->line(' Date:' . dbDatetimeToDate( $this->bookingOrder->starts_at ) )
                    // ->line(' Starts At:' . dbDatetimeToTime( $this->bookingOrder->starts_at ) )
                    // ->line(' Ends At:' . dbDatetimeToTime( $this->bookingOrder->ends_at ) )
                    // ->line(' Status: Cancelled' )
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
            'link'=> route('admin.bookings.index'),
            'text'=> 'Booking cancellation confirmation!',
            'details'=>'You have Cancelled a service booking'
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
                'You have Cancelled a service booking',
                $notifiable->push_token,
                $url = null,
                $data = null,
                $buttons = null,
                $schedule = null,
                $headings = 'Booking cancellation confirmation!',
                $subtitle = null
            );
        }
    }
}

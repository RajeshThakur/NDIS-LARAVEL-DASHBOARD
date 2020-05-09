<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Broadcasting\MobileChannel;

use Carbon\Carbon;

class ServiceBookingCancelled extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $participant;
    protected $worker;
    protected $external;
    protected $bookingOrder;
    protected $within24;

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
        $this->participant = \App\User::find($bookingOrder->booking->participant_id);
        $this->worker = \App\User::find($bookingOrder->booking->supp_wrkr_ext_serv_id);
        $this->external = \App\User::find($bookingOrder->booking->supp_wrkr_ext_serv_id);      
        $this->within24 = ( Carbon::parse($bookingOrder->starts_at)->diffInMinutes(Carbon::now()) <= 1440 );
        
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
        $participantName = $this->participant->first_name . $this->participant->last_name ;
        $workerName = is_null($this->external) ? $this->worker->first_name . $this->worker->last_name : $this->external->first_name . $this->external->last_name ;
        return (new MailMessage)
                ->subject('['.config('app.name').' - Service Booking] Service Booking Cancelled!')
                ->view('mail.serviceBookingCancelled', ['user' => $this->user, 'bookingOrder' => $this->bookingOrder, 'participantName' => $participantName, 'workerName' => $workerName, 'within24' => $this->within24]);
               // ->greeting(sprintf('Hi %s %s,', $this->user->first_name, $this->user->last_name ) )
                // ->line(sprintf('A service booking of which you are a part of is cancelled!'))
                // ->line('details of the cancelled service bookings are: ' )
                // ->line(' Date:' . dbDatetimeToDate( $this->bookingOrder->starts_at ) )
                // ->line(' Starts At:' . dbDatetimeToTime( $this->bookingOrder->starts_at ) )
                // ->line(' Ends At:' . dbDatetimeToTime( $this->bookingOrder->ends_at ) )
                // ->line(' Status: Cancelled' )
                // ->line('&nbsp;' )
                // ->line('The Service Booking between '.$participantName.' and '. $workerName .' at ' . dbDatetimeToTime( $this->bookingOrder->starts_at ) . ' on the ' . dbDatetimeToDate( $this->bookingOrder->starts_at ) .' at ' . $this->bookingOrder->booking->location . ' has been cancelled ' )
                // ->line($this->within24 ? 'within 24 hours':'.')
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
            'link'=> route('admin.index'),
            'text'=> 'Service Booking Cancelled!',
            'details'=>'A service booking of which, you were a member has been cancelled!'
        ];
    }

    /**
     * send the notification to the Mobile App if User is registered
     *
     * @param  mixed  $notifiable
     */
    public function toMobile($notifiable){

        $participantName = $this->participant->first_name . $this->participant->last_name ;
        $workerName = is_null($this->external) ? $this->worker->first_name . $this->worker->last_name : $this->external->first_name . $this->external->last_name ;

        if($notifiable->push_token){
            \OneSignal::sendNotificationToUser(
                'The Service Booking between '.$participantName.' and '. $workerName .' at ' . dbDatetimeToTime( $this->bookingOrder->starts_at ) . ' on the ' . dbDatetimeToDate( $this->bookingOrder->starts_at ) .' at ' . $this->bookingOrder->booking->location . ' has been cancelled' . ( $this->within24 ? 'within 24 hours':'.'),
                $notifiable->push_token,
                $url = null,
                $data = null,
                $buttons = null,
                // $buttons = [
                //     ["id"=>$this->data['id'], "text"=> "View Event", "icon"=>"ic_menu_send"]
                // ],
                $schedule = null,
                $headings = "Service Booking Cancelled!",
                $subtitle = null
            );
        }
    }
}

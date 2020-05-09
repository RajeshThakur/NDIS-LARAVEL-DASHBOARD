<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Broadcasting\MobileChannel;

class ServiceBookingCreated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $booking_order;
    protected $provider;
    protected $worker;
    protected $participant;
    protected $item;
    protected $line;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $booking_order, $participant, $provider, $worker, $for )
    {
        $this->queue = 'notifications';
        $this->booking_order = $booking_order;
        $this->participant = $participant;
        $this->provider = $provider;
        $this->worker = $worker;
        $this->item = \App\RegistrationGroup::find($booking_order->booking->item_number);

        if( 'participant' == $for ){
            $this->line = sprintf('A Service Booking for ' . $this->item->title  . ' has been created for you with Support Worker ' . $this->worker->getName() . ' at ' .dbDateToTime($this->booking_order->starts_at). ' on the ' . dbToDate($this->booking_order->starts_at) );
        }
        if( 'worker' == $for ){
            $this->line = sprintf('A Service Booking for ' . $this->item->title  . ' has been created for you with Participant ' . $this->participant->getName() . ' at ' .dbDateToTime($this->booking_order->starts_at). ' on the ' . dbToDate($this->booking_order->starts_at) );
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
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // We can use this Method using the Job
        // $job = (new SendFriendRequestEmailJob($notifiable))->onQueue('email');
        // dispatch($job);        

        return (new MailMessage)
            ->subject('['.config('app.name').' - Service Booking] New Service Booking Created!')
            ->view('mail.serviceBookingCreated', ['line' => $this->line, 'notifiable' => $notifiable]);
            // ->greeting(sprintf('Hi %s,', $notifiable->getName() ) )
            // ->line( $this->line )
            // ->line('Thank you for using '.config('app.name').'!');

        // if($this->booking->service_type == "support_worker"){
        //     $worker = sprintf('Support Worker: %s', $this->worker->getName());           
        // }else{
        //     $worker = sprintf('Service Provider: %s', $this->worker->first_name .' '.$this->worker->last_name);
        // }
        // return (new MailMessage)
        //     ->subject('['.config('app.name').' - Service Booking] New Service Booking Created!')
        //     ->greeting(sprintf('Hi %s,', $notifiable->getName() ) )
        //     ->line(sprintf('A new service booking request has been created by %s!',$this->provider->getName()))
        //     ->line('Details for the Service Booking is as followed:')
        //     ->line(sprintf('Participant: %s', $notifiable->getName() ))
        //     ->line($worker)
        //     ->line(sprintf('Starts At: %s',$this->booking_order->starts_at))
        //     ->line(sprintf('Ends At: %s',$this->booking_order->ends_at))
        //     ->line('More details can be found under the Mobile App!')
            
        //     ->line('Thank you for using '.config('app.name').'!');
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
            'link'=> route('admin.bookings.edit', [$this->booking_order->order_id]),
            'text'=> 'A New Service Booking Created!',
            'details'=>$this->line
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
                $schedule = null,
                $headings = "A New Service Booking Created!",
                $subtitle = null
            );
        }
    }
    
}
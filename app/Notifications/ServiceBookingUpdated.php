<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Broadcasting\MobileChannel;

class ServiceBookingUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $booking;
    protected $provider;
    protected $worker;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->queue = 'notifications';
        $this->booking = $booking;
        $this->provider = $provider;
        $this->worker = $worker;
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

        if($this->booking->service_type == "support_worker"){
            $worker = sprintf('Support Worker: %s', $this->worker->first_name .' '.$this->worker->last_name);
        }else{
            $worker = sprintf('Service Provider: %s', $this->worker->first_name .' '.$this->worker->last_name);
        }
        return (new MailMessage)
                ->subject('['.config('app.name').'] Service Booking Updated!')
                ->view('mail.serviceBookingUpdated', ['booking' => $this->booking, 'worker' => $worker, 'notifiable' => $notifiable]);
                // ->greeting(sprintf('Hi %s,', $notifiable->getName() ) )
                // ->line(sprintf('A service booking, involving you has been updated!'))
                // ->line('Details for the Service Booking is as followed:')
                // ->line(sprintf('Participant: %s',$notifiable->getName()))
                // ->line($worker)
                // ->line(sprintf('Starts At: %s',$this->booking->starts_at))
                // ->line(sprintf('Ends At: %s',$this->booking->ends_at))
                // ->line('More details can be found under the Mobile App!')
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
            'link'=> route('admin.bookings.edit', [$this->booking->order_id]),
            'text'=> 'Service Booking Updated!',
            'details'=>'A service booking, involving you has been updated'
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
                'A service booking, involving you has been updated',
                $notifiable->push_token,
                $url = null,
                $data = null,
                $buttons = null,
                $schedule = null,
                $headings = 'Service Booking Updated!',
                $subtitle = null
            );
        }
    }
}

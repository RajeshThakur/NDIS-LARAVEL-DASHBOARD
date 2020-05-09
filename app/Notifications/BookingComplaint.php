<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Broadcasting\MobileChannel;

class BookingComplaint extends Notification implements ShouldQueue
{
    use Queueable;

    protected $reporter;
    protected $complaint;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $reporter, $complaint )
    {
        $this->queue = 'notifications';
        $this->reporter = $reporter;
        $this->complaint = $complaint;
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
                    ->subject('['.config('app.name').' - Service Booking] New Complaint Reported by '.$this->reporter->getName()."!")
                    ->view('mail.bookingComplaint', ['complaint' => $this->complaint, 'notifiable'=>$notifiable, 'reporter' => $this->reporter ]);
                    // ->greeting(sprintf('Hi %s,', $notifiable->getName() ))
                    // // ->line('A new complaint has been reported on, One of your Service Booking. Click the link below to view the Service Booking:')
                    // ->line( $this->reporter->getName(). ' has submitted Complaint Submission on ' . dbToDate($this->complaint->created_at) )
                    // ->action('View complaint', $this->complaint->url)
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
            'link'=>route("admin.bookings.edit", [$this->complaint->booking_order_id]),
            // 'text'=>'New booking complaint reported by '.$this->reporter->getName(),
            'text'=>  $this->reporter->getName(). ' has submitted Complaint Submission on ' . dbToDate($this->complaint->created_at),
            'details'=>'Complaint is created for the Booking Order ID:'.$this->complaint->booking_order_id
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
            'link'=>route("admin.bookings.edit", [$this->complaint->booking_order_id]),
            'text'=>$this->reporter->getName(). ' has submitted Complaint Submission on ' . dbToDate($this->complaint->created_at),
            'details'=>'Complaint is created for the Booking Order ID:'.$this->complaint->booking_order_id
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
                'Complaint is created for the Booking Order ID:'.$this->complaint->booking_order_id,
                $notifiable->push_token,
                $url = null,
                $data = null,
                $buttons =null,
                $schedule = null,
                $headings = $this->reporter->getName(). ' has submitted Complaint Submission on ' . dbToDate($this->complaint->created_at),
                $subtitle = null
            );
        }
    }

}

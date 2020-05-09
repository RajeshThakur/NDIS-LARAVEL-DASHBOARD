<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Broadcasting\MobileChannel;
use Carbon\Carbon;

class EventCreated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $data;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->queue = 'notifications';
        $this->data = $data;
    }

    /**
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    // public function routeNotificationForMail($notification)
    // {
    //     return $this->email_address;
    // }

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
        $startDateTime = dbToDatetime( $this->data['due_date'] . " " . $this->data['start_time'] );
        $endDateTime = dbToDatetime( $this->data['due_date'] . " " . $this->data['end_time'] );
        return (new MailMessage)
                    ->subject('['.config('app.name').' - Task Added ] '.$this->data['name'] ."!" )
                    ->view('mail.bookingTaskCreated', ['data' => $this->data, 'startDateTime' => $startDateTime, 'endDateTime' => $endDateTime, 'notifiable' => $notifiable]);
                    // ->greeting(sprintf('Hi %s,', $notifiable->getName() ))
                    // ->line('You have been assigned to a new Event')
                    // ->line( "----- " . $this->data['name'] . " -----" )
                    // ->line($this->data['description'])
                    // ->line("Starts from :". $startDateTime )
                    // ->line("Ends at :". $endDateTime )
                    // ->action('Check Event Status', route('admin.events.show', [$this->data['id']]) )
                    // ->line('Thank you for using '.config('app.name').'!');
    }

    /**
     * Get the array representation of the notification.
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'link'=>route("admin.events.edit", [$this->data['id']]),
            'text'=>"A New Event ( ".$this->data['name']." ) is created",
            'details'=>'A New Event is created for you!'
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
            'link'=>route("admin.events.edit", [$this->data['id']]),
            'text'=>"A New Event ( ".$this->data['name']." ) is created",
            'details'=>'A New Event is created for you!'
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
                'To view the event, please click!',
                $notifiable->push_token,
                $url = null,
                $data = null,
                $buttons = null,
                // $buttons = [
                //     ["id"=>$this->data['id'], "text"=> "View Event", "icon"=>"ic_menu_send"]
                // ],
                $schedule = null,
                $headings = "A New Event ( ".$this->data['name']." ) is created",
                $subtitle = null
            );
        }
    }

}

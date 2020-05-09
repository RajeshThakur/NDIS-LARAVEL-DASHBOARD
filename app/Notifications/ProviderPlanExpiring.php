<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Broadcasting\MobileChannel;
use Carbon\Carbon;

class ProviderPlanExpiring extends Notification implements ShouldQueue
{
    use Queueable;

    protected $data;
    protected $time;
    protected $subject;
    protected $line;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $data, $time )
    {
        $this->queue = 'notifications';
        $this->data = $data;
        $this->time = $time;

        $this->subject = trans('notifications.provider_ndis_plan.subject.'.$this->time );
        $this->line = trans('notifications.provider_ndis_plan.msg.'.$this->time);
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
                ->subject('['.config('app.name').' - '.$this->subject )
                ->view('mail.providerPlanExpiring', ['notifiable' => $notifiable, 'data' => $this->data ]);
                // ->greeting(sprintf('Hi %s,', $notifiable->getName() ))
                // // ->line('Your NDIS plan is due for renewal on '.$this->data['end_date_ndis'].'.' )
                // ->line( $this->line )
                // ->action('Renew NDIS plan now', route('admin.users.profile', [$this->data->user_id]) )
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
            'link'=>route('admin.users.profile', [$this->data->user_id]),
            'text'=>$this->subject,
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
                $this->subject,
                $notifiable->push_token,
                $url = null,
                $data = null,
                $buttons = null,
                // $buttons = [
                //     ["id"=>$this->data['id'], "text"=> "View Event", "icon"=>"ic_menu_send"]
                // ],
                $schedule = null,
                $headings = $this->line,
                $subtitle = null
            );
        }
    }
}

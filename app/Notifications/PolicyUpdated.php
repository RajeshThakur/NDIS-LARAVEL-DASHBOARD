<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Broadcasting\MobileChannel;
use Carbon\Carbon;

class PolicyUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $line;
    protected $subject;
    protected $contentPage;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $contentPage )
    {
        $this->queue = 'notifications';

        $this->contentPage = $contentPage;

        $this->subject = trans('notifications.policy_updated.subject' );
        $this->line = trans('notifications.policy_updated.msg' );

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
                    ->view('mail.policyUpdated', ['notifiable' => $notifiable]);
                    // ->greeting(sprintf('Hi %s,', $notifiable->getName() ))
                    // ->line( $this->line )
                    // ->action('View updates here', route('login') )
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
            'link'=>"",
            'text'=>$this->subject,
            'details'=>$this->line
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
            'link'=>"",
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
                $this->line,
                $notifiable->push_token,
                $url = null,
                $data = null,
                $buttons = null,
                // $buttons = [
                //     ["id"=>$this->data['id'], "text"=> "View Event", "icon"=>"ic_menu_send"]
                // ],
                $schedule = null,
                $headings = $this->subject,
                $subtitle = null
            );
        }
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Broadcasting\MobileChannel;
use Carbon\Carbon;

class WorkerAgreementExpiring extends Notification implements ShouldQueue
{
    use Queueable;

    protected $expiry_date;
    protected $duration;
    protected $subject;
    protected $line;
    protected $worker;
    protected $provider;
    protected $for;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $worker, $provider, $expiry_date, $duration, $for )
    {
        $this->queue = 'notifications';
        $this->expiry_date = $expiry_date;
        $this->worker = $worker;
        $this->provider = $provider;
        $this->duration = $duration;
        $this->for = $for;

        if( $for == 'provider'):
            $this->subject = trans( 'notifications.worker_agreement.provider.subject.'.$this->duration, ['name' => $this->worker->getName()] );
            $this->line = trans( 'notifications.worker_agreement.provider.msg.'.$this->duration, ['name' => $this->worker->getName()] );
        endif;
        if( $for == 'worker'):
            $this->subject = trans('notifications.worker_agreement.worker.subject.'.$this->duration );
            $this->line = trans('notifications.worker_agreement.worker.msg.'.$this->duration );
        endif;
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
                    ->subject( '['.config('app.name').' - '.$this->subject )
                    ->view('mail.workerAgreementExpiring', ['notifiable' => $notifiable, 'line' => $this->line]);
                    // ->greeting(sprintf('Hi %s,', $notifiable->getName() ))
                    // ->line( $this->line )
                    // // ->action('Renew NDIS plan now', route('login') )
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
        if( $this->for == 'provider'):
            return [
                'link'=>route('admin.support-workers.edit', [$this->worker->id]),
                'text'=>$this->subject,
                'details'=>$this->line
            ];
        endif;

        return [
            //
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

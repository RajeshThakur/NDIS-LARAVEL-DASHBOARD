<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Broadcasting\MobileChannel;
use Carbon\Carbon;

class ParticipantAgreementExpiring extends Notification implements ShouldQueue
{
    use Queueable;

    protected $expiry_date;
    protected $duration;
    protected $subject;
    protected $line;
    protected $participant;
    protected $provider;
   

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $participant, $provider, $expiry_date, $duration, $for )
    {
        $this->queue = 'notifications';
        $this->expiry_date = $expiry_date;
        $this->participant = $participant;
        $this->provider = $provider;
        $this->duration = $duration;

        if( $for == 'provider'):
            $this->subject = trans( 'notifications.participant_agreement.provider.subject.'.$this->duration, ['name' => $this->participant->getName()] );
            $this->line = trans( 'notifications.participant_agreement.provider.msg.'.$this->duration, ['name' => $this->participant->getName()] );
        endif;
        if( $for == 'participant'):
            $this->subject = trans('notifications.participant_agreement.participant.subject.'.$this->duration );
            $this->line = trans('notifications.participant_agreement.participant.msg.'.$this->duration );
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
                    ->view('mail.participantAgreementExpiring', ['line' => $this->line, 'notifiable' => $notifiable]);
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

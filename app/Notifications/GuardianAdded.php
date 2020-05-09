<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Broadcasting\MobileChannel;

class GuardianAdded extends Notification implements ShouldQueue
{
    use Queueable;

    protected $guardian;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($guardian)
    {
        $this->queue = 'notifications';
        $this->guardian = $guardian;
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
                ->subject('['.config('app.name').'] - Guardian added successfully' )
                ->view('mail.guardianAdded', ['guardian' => $this->guardian,'notifiable' => $notifiable]);
                // ->greeting(sprintf('Hi %s,', $notifiable->getName() ))
                // ->line('A Guardian for your participant account with '.config('app.name').' has been added successfully!')
                // ->line( "----- Details -----" )
                // ->line( "Name: ".$this->guardian->name )
                // ->line( "Email: ".$this->guardian->email )
                // ->line( "Address: ".$this->guardian->address )
                // ->line( "Phone: ".$this->guardian->phone )
                // ->line( "mobile: ".$this->guardian->mobile )
                // ->line('If you do not have requested for any guardian or you want to update any of the above details, pleae contact NDISCentral.')
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
            'link'=>'#',
            'text'=>"Guardian ".$this->guardian->name." is added for your participant account.",
            'details'=>"A new Guardian ".$this->guardian->name." has been added to your account to perform actions on your behalf."
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
                "A new Guardian ".$this->guardian->name." has been added to your account to perform actions on your behalf",
                $notifiable->push_token,
                $url = null,
                $data = null,
                $buttons = null,
                $schedule = null,
                $headings = "Guardian ".$this->guardian->name." is added for your participant account",
                $subtitle = null
            );
        }
    }
    
}

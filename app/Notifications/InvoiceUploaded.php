<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class InvoiceUploaded extends Notification implements ShouldQueue
{
    use Queueable;

    protected $data;
    protected $participant;
    protected $sw;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->queue = 'notifications';
        $this->data = $data;
        $this->participant = \App\User::find($data['participant']);
        $this->sw = \App\User::find($data['sw']);
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
        return (new MailMessage)
                ->subject('['.config('app.name').'] An invoice is uploaded !')
                ->view('mail.invoiceUploaded', ['participant' => $this->participant,'sw'=>$this->sw, 'data' => $this->data ]);
                // ->line( 'Invoice for Service Booking between ' . $this->participant->getName() . ' and ' . $this->sw->getName() . '  at ' . dbDateToTime($this->data['time']) . '  on the ' . dbToDate($this->data['time']) . ' has been uploaded by Participant ' . $this->participant->getName())
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
            'subject' =>  "Invoice uploaded",
            'body'    =>  'Invoice for Service Booking between ' . $this->participant->getName() . ' and ' . $this->sw->getName() . '  at ' . dbDateToTime($this->data['time']) . '  on the ' . dbToDate($this->data['time']) . ' has been uploaded by Participant ' . $this->participant->getName()
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
            'link'=>'',
            'text'=> "Invoice uploaded",
            'details'=> 'Invoice for Service Booking between ' . $this->participant->getName() . ' and ' . $this->sw->getName() . '  at ' . dbDateToTime($this->data['time']) . '  on the ' . dbToDate($this->data['time']) . ' has been uploaded by Participant ' . $this->participant->getName()
        ];
    }

}

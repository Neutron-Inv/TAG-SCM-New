<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class RFQAcknowledge extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $arr)
    {
       $this->arr = $arr;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $clientRfq = $this->arr['rfq'];
        $contact = $this->arr['conc'];
        $name = $contact->first_name . ' '. $contact->last_name;
        return (new MailMessage)
            ->subject('Re: RFQ ' .$clientRfq->rfq_number. "- Purchase of " .$clientRfq->product. ' Acknowledgement: (Our ref: ". '.$clientRfq->refrence_no. " )")
            ->line('Dear ' .$name. '!')
            ->line('This is to acknowledge receipt of your RFQ ' .$clientRfq->refrence_no. " for purchase of ".$clientRfq->product)
            ->line('We will work on this and revert with a price quotation on or before the submission due date as per your request')
            ->line('Thank you very much for this opportunity')
            ->line('PHONE: +234 1 342 8420 | +234 806 8840')
            ->line('EMAIL: '. Auth::user()->email)
            ->action('Visit Website', url('http://scm.enabledjobs.com/'))
            ->line('Thank you!');
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
}

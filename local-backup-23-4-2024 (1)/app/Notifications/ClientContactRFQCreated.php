<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use App\{ User,Employers,ClientRfq, ClientContact};

class ClientContactRFQCreated extends Notification
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
        $contact = $this->arr['conc'];
        $name = $contact->first_name . ' '. $contact->last_name;
        $clientRfq = $this->arr['rfq'];
        return (new MailMessage)
            ->subject('Re: Status Of Inquiry For RFQ' .$clientRfq->rfq_number. ": TAG-RFQ" .$clientRfq->refrence_no. " ". $clientRfq->product)
            ->line('Dear ' .$name. '!')
            // ->line('A new rfq has been assigned to you by '.Auth::user()->first_name.' '.Auth::user()->last_name)
            ->line('Good day. I trust that this mail meets you well')
            ->line('Thank you very much for the opportunity to submit our quotation for RFQ-' .$clientRfq->rfq_number. " Please advise us on the status of this submission" )
            ->line('Hope to hear from you soon.')
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

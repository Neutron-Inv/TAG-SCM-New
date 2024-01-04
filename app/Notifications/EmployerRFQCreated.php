<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use App\{ User,Employers,ClientRfq, ClientContact};

class EmployerRFQCreated extends Notification
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
        $emp = $this->arr['emp'];
        return (new MailMessage)
        ->subject('SCM New RFQ Posting Notification for Purchase of '.$clientRfq->product)
        ->line('Dear '. $emp->full_name . '!')
        ->line('A new rfq has been assigned to you by '.Auth::user()->first_name.' '.Auth::user()->last_name)
         ->line('Kindly search this RFQ '.$clientRfq->refrence_no.  ' on the website below:')
         ->action('Visit Website', url('http://scm.enabledjobs.com/'))
        ->line('Thank you for using SCM!');
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

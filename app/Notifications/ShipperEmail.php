<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class ShipperEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $arr2)
    {
       $this->arr2 = $arr2;
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
        $clientRfq = $this->arr2['rfq'];
        $vendor = $this->arr2['vendor'];
        $ship = $this->arr2['ship'];
        return (new MailMessage)
        ->subject('SCM Request for Shipper Quotation for '.$clientRfq->product)
        ->line('Dear '. $vendor->first_name.' '.$vendor->last_name . '!')
        ->line('A new rfq has been assigned to you by '.Auth::user()->first_name.' '.Auth::user()->last_name)
         ->line('Kindly search this RFQ '.$clientRfq->refrence_no.  ' on the website below to submit your Quotation:')
        ->action('Notification Action', url('http://scm.enabledjobs.com/'))
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

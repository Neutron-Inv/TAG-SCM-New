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
        use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $rfq_no = $this->data['rfq_no'];
        $reference_no = $this->data['reference_no'];
        $description = $this->data['description'];
        $mail = $this->subject('Re: Status Of Inquiry For RFQ' .$rfq_no. ": TAG-RFQ" .$reference_no. " ". $description)->markdown('emails.notification.StatusEnquiry')->with(compact('rfq_no'));
    }
}

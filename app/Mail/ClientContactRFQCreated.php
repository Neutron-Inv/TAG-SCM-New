<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientContactRFQCreated extends Mailable
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
     * Build the message    .
     *
     * @return $this
     */
    public function build()
    {
        $rfq_no = $this->data['rfq_no'];
        $reference_no = $this->data['reference_no'];
        $description = $this->data['description'];
        $mail = $this->subject('Re: Status Of Inquiry For RFQ' .$rfq_no. ": " .$reference_no. " ". $description)->markdown('emails.notification.StatusEnquiry')->from('sales@tagenergygroup.net', 'TAG Energy Sales')->with(compact('rfq_no', 'reference_no'));
    }
}

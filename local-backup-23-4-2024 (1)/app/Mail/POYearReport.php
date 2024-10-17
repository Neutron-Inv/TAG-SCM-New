<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class POYearReport extends Mailable
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
        $po = $this->data['po'];
        $shipper = $this->data['shipper'];
        $mail = $this->subject("YEAR TO DATE ON-TIME DELIVERY REPORTS & SHIPPERS PERFORMANCE EVALUATION")->markdown('emails.po.yearly')->with(compact('shipper','po'));
    }
}

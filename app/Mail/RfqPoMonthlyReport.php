<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RfqPoMonthlyReport extends Mailable
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
        $rfq = $this->data['rfq'];
        $product = $this->data['product'];
        $topclients = $this->data['topclients'];
        $mail = $this->subject("TAG Year to Date List of RFQ's & PO's for ". date('Y'))->markdown('emails.po.TAGMonthly')->with(compact('rfq','po', 'product', 'topclients'));
    }
}

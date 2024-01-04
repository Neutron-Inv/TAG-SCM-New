<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomReport extends Mailable
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
        $rfqtotal = $this->data['rfqtotal'];
        $pototal = $this->data['pototal'];
        $grn = $this->data['grn'];
        $start_date = $this->data['start_date'];
        $end_date = $this->data['end_date'];
        $clients = $this->data['clients'];
        $client = $this->data['client'];
        $mail = $this->subject("Custom Client Report")->markdown('emails.rfq.customreport')->with(compact('po','rfq','rfqtotal','pototal','grn','start_date','end_date','clients','client'));
    }
}

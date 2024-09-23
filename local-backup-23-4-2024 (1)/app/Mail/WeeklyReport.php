<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WeeklyReport extends Mailable
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
        $rfq = $this->data['rfq'];
        $rfqtotal = $this->data['rfqtotal'];
        $pototal = $this->data['pototal'];
        $po = $this->data['po'];
        $monday = $this->data['monday'];
        $friday = $this->data['friday'];
        $grn = $this->data['grn'];
        $mail = $this->subject("TAG Energy RFQ and POs Weekly Report as at - ".date('d-m-Y'))->markdown('emails.po.WeeklyReport')->with(compact('rfq','rfqtotal','po','pototal','monday','friday','grn'));
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RfqReport extends Mailable
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
        $company = $this->data['company'];
        $rfq = $this->data['rfq'];
        $tq = $this->data['tq'];
        $shi = $this->data['shi'];
        $shiname = $this->data['shiname'];
        $reference_no = $this->data['reference_no'];
        $line_items = $this->data['line_items'];
        $po = $this->data['po'];
        $po_number = $this->data['po_number'];
        $mail = $this->subject("TAG Energy RFQ Report")->markdown('emails.rfq.report')->with(compact('company','rfq','tq','shi','shiname','reference_no','line_items','po','po_number'));
    }
}

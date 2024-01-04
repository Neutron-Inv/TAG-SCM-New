<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class POAcknowledge extends Mailable
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
        $emp = $this->data['emp'];
        $vendor = $this->data['vendor'];
        $rfq = $this->data['rfq'];
        $contact = $this->data['conct'];
        $mail = $this->subject("PO $po->po_number ACKNOWLEDGEMENT: TE-".$vendor->vendor_code."-".$rfq->rfq_number .', '. $rfq->product)->markdown('emails.po.po-acknowledge')->with(compact('po', 'emp', 'contact'));
        $mail->from('sales@tagenergygroup.net');
        return $mail;
    }
}

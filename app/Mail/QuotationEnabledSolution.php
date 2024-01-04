<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuotationEnabledSolution extends Mailable
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
        $dir = $this->data['dir'];
        // $sender = $this->data['sender'];
        $company = $this->data['company'];
        $mail = $this->from('contact@enabledsolutions.net', $company->company_name)->replyTo('contact@enabledsolutions.net', $company->company_name)->subject("QUOTATION FOR RFX " .$rfq->rfq_number.': '. $rfq->refrence_no . ', '. strtoupper($rfq->product))->view('emails.rfq.quotation')->with(['rfq' => $rfq, 'sender' => 'contact@enabledsolutions.net']);
        $list = array_values(array_diff(scandir($dir, 0), array('..', '.')));
        foreach ($list as $key) {
            $mail->attach($dir.'/'.$key);
        }
        return $mail;
    }
}

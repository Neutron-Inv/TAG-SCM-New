<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GRNEnquiryRequest extends Mailable
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
        $po_no = $this->data['po_no'];
        $client_name = $this->data['client_name'];
        $reference_no = $this->data['reference_no'];
        $description = $this->data['description'];
        $assigned = $this->data['assigned'];
        $type = $this->data['type'];
        
        if($type == 'Reminder'){
        $mail = $this->subject('URGENT: Request for GRN for ' .$client_name. " PO " .$po_no. ": ". $reference_no.", ".$description)->markdown('emails.notification.GRNEnquiry')->from('sales@tagenergygroup.net', 'TAG Energy Sales')->with(compact('assigned', 'reference_no','type'));
        }elseif($type == '14-Day Follow-up'){
            $mail = $this->subject('REMINDER: Request for GRN for ' .$client_name. " PO " .$po_no. ": ". $reference_no.", ".$description)->markdown('emails.notification.GRNEnquiry')->with(compact('assigned', 'reference_no','type'));
        }
        // Set high importance (1) to the email
        $mail->withSwiftMessage(function ($message) {
            $message->setPriority(1);
        });
    }
}

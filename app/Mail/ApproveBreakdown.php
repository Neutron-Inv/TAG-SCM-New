<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApproveBreakdown extends Mailable
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
        $reason = $this->data['reason'];
        $status = $this->data['status'];
        $company = $this->data['company'];
        $rfqcode = $this->data['rfqcode'];
        $assigned = $this->data['assigned'];
        $company_id = $rfq->company_id;
        if($company_id == 1){
            $sender =  'contact@enabledsolutions.net';
            $reply ='contact@enabledsolutions.net';
        }elseif($company_id == 2){
            $sender = 'sales@tagenergygroup.net';
            $reply = 'sales@tagenergygroup.net';
        }elseif($company_id == 3){
            $sender = 'contact@gloriousempiretech.com';
            $reply = 'contact@gloriousempiretech.com';
        }elseif($company_id == 15){
            $sender = 'contact@enabledgroup.net';
            $reply = 'contact@enabledgroup.net';
        }elseif($company_id == 20){
            $sender = 'sales@taglinesng.com';
            $reply = 'sales@taglinesng.net';
        }else{
            $name = cops($company_id);
            $sender = $name->email;
            $reply = $name->email;
        }
<<<<<<< HEAD
        $mail = $this->replyTo($reply, $company->company_name)->subject($status. ' to Submit Price Quotation for ' .$rfqcode.' : '. $assigned . ', '.$rfq->description)->view('emails.rfq.breakdown')
=======
        $mail = $this->replyTo($reply, $company->company_name)->subject($status. ' to Submit Price Quotation for ' .$rfqcode.' : , '.$rfq->description)->view('emails.rfq.breakdown')
>>>>>>> master
        ->with([
            'rfq' => $rfq,'sender' => $sender, 'reply' => $reply, 'reason' => $reason, 'status' => $status, 'assigned' => $assigned
        ]);
        return $mail;
    }
}
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Quotation extends Mailable
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
        $mail = $this->from($sender, $company->company_name)->replyTo($reply, $company->company_name)->subject("QUOTATION SUBMISSION FOR RFX " .$rfq->rfq_number.': '. $rfq->refrence_no . ', '. strtoupper($rfq->product))->view('emails.rfq.quotation')
        ->with([
            'rfq' => $rfq,'sender' => $sender, 'reply' => $reply
        ]);
        //$mail = $this->subject("QUOTATION FOR RFX " .$rfq->rfq_number.': '. $rfq->refrence_no . ', '. strtoupper($rfq->product))->markdown('emails.rfq.quotation')->with(compact('rfq'));
        $list = array_values(array_diff(scandir($dir, 0), array('..', '.')));
        // $mail->from('sales@tagenergygroup.net');
        foreach ($list as $key) {
            $mail->attach($dir.'/'.$key);
        }
        return $mail;

    }
}

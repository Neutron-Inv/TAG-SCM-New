<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupplierQuotation extends Mailable
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
        $po = $this->data['po'];
        $vendor = $this->data['vendor'];
        $dir = $this->data['dir'];
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
        $slug = 'TE-' . $vendor->vendor_code . '-'. $rfq->short_code;
        $mail = $this->from($sender, $company->company_name)->replyTo($reply, $company->company_name)->subject(
            "Purchase Order for Supply of ". strtoupper($rfq->product).":" .$slug)->view('emails.rfq.supplier-quote')
        ->with([ 'rfq' => $rfq, 'vendor' => $vendor,
            'sender' => $sender, 'reply' => $reply, 'po' => $po
        ]);

        $list = array_values(array_diff(scandir($dir, 0), array('..', '.')));

        foreach ($list as $key) {
            $mail->attach($dir.'/'.$key);
        }
        return $mail;

    }
}

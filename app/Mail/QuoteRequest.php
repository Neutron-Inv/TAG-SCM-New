<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuoteRequest extends Mailable
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
        $assigned = $this->data['assigned'];
        $client_name = $this->data['client_name'];
        $company = $this->data['company'];
        $vendor_contact = $this->data['vendor_contact'];
        $extra_note = $this->data['extra_note'];
        $tempFilePath = $this->data['tempFilePath'];
        $tempFileDirs = $this->data['tempFileDirs'];
        $fileNames = $this->data['fileNames'];
        $rfqcode = $this->data['rfqcode'];
        $mail_id = $this->data['mail_id'];
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
        $mail = $this->replyTo($reply, $company->company_name)->subject("Request for Pricing Information: - " .$rfqcode." ".$rfq->description)->markdown('emails.rfq.SupplierRequest')
        ->with(compact('rfq', 'sender', 'reply', 'extra_note', 'vendor_contact'));
        
        if($tempFilePath != ""){
            $mail->attach($tempFilePath);
            }
        
        if($tempFileDirs != ""){
            // Attach files to the email
            for ($i = 0; $i < count($tempFileDirs); $i++) {
                $mail->attach($tempFileDirs[$i], ['as' => $fileNames[$i]]);
            }
        }
        
        $mail->withSwiftMessage(function ($message) use ($mail_id) {
            $message->getHeaders()->addTextHeader('X-rfq-id', $mail_id);
        });
        
        //dd($mail);
        // $mail->from($sender);
        return $mail;
    }
}

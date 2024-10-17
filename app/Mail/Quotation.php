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
        $rfqcode = $this->data['rfqcode'];
        $dir = $this->data['dir'];
        $tempFilePath = $this->data['tempFilePath'];
        $tempFileDirs = $this->data['tempFileDirs'];
        $fileNames = $this->data['fileNames'];
        // $inReplyTo = $this->data['inReplyTo'];
        // $references = $this->data['references'];
        $extra_note = $this->data['extra_note'];
        // $sender = $this->data['sender'];
        $company = $this->data['company'];
        $company_id = $rfq->company_id;
        if($company_id == 1){
            $sender =  'contact@enabledsolutions.net';
            $reply ='contact@enabledsolutions.net';
            $company_name = 'Enabled Solutions';
            $bcc = 'contact@enabledsolutions.net';
        }elseif($company_id == 2){
            $sender = 'sales@tagenergygroup.net';
            $reply = 'sales@tagenergygroup.net';
            $company_name = 'TAG Energy';
            $bcc = 'contact@tagenergygroup.net';
        }elseif($company_id == 3){
            $sender = 'contact@gloriousempiretech.com';
            $reply = 'contact@gloriousempiretech.com';
            $company_name = 'Glorious Empiretech';
            $bcc = 'contact@gloriousempiretech.com';
        }elseif($company_id == 15){
            $sender = 'contact@enabledgroup.net';
            $reply = 'contact@enabledgroup.net';
            $company_name = 'Enabled Group';
            $bcc = 'hq@enabledgroup.net';
        }elseif($company_id == 20){
            $sender = 'sales@taglinesng.com';
            $reply = 'sales@taglinesng.com';
            $company_name = 'TAG Lines';
            $bcc = 'contact@taglinesng.com';
        }else{
            $name = cops($company_id);
            $sender = $name->email;
            $reply = $name->email;
        }
        $mail = $this->from($sender, $company_name.' Sales')->replyTo($reply, $company_name.' Sales')->subject("Re: ".$rfq->rfq_number." - ".$company_name." Quotation Submission For Purchase of " .$rfq->description.': '. $rfqcode)->view('emails.rfq.quotation')
        ->with([
            'rfq' => $rfq,'sender' => $sender, 'reply' => $reply, 'extra_note' => $extra_note
        ]);
        

        if($tempFilePath != ""){
            $mail->attach($tempFilePath);
            }
        
        if($tempFileDirs != ""){
            // Attach files to the email
            for ($i = 0; $i < count($tempFileDirs); $i++) {
                $mail->attach($tempFileDirs[$i], ['as' => $fileNames[$i]]);
            }
        }
        
       // Add In-Reply-To and References headers
        // $mail->withSwiftMessage(function ($message) use ($inReplyTo, $references) {
        //     $headers = $message->getHeaders();
        //     if (!empty($inReplyTo)) {
        //         $headers->addTextHeader('In-Reply-To', $inReplyTo);
        //     }
        //     if (!empty($references)) {
        //         $headers->addTextHeader('References', $references);
        //     }
        // });
        
        return $mail;

    }
}

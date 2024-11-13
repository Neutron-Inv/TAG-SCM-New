<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Submission extends Mailable
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
        $tq = $this->data['tq'];
        $extra_note = $this->data['extra_note'];
        $shiname = $this->data['shiname'];
        $tempFilePath = $this->data['tempFilePath'];
        $tempFileDirs = $this->data['tempFileDirs'];
        $fileNames = $this->data['fileNames'];
        $rfqcode = $this->data['rfqcode'];
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
        $mail = $this->replyTo($reply, $company->company_name)->subject("Request for Approval to Submit Quotation - " .$rfqcode." for ".$client_name." ".$rfq->description." - ".$assigned)->markdown('emails.rfq.approval')
        ->with(compact('rfq', 'sender', 'reply', 'tq', 'shiname', 'extra_note'));
        // $mail = $this->subject("QUOTATION BREAKDOWN APPROVAL FOR RFX " .$rfq->rfq_number.': '. $rfq->refrence_no . ', '. strtoupper($rfq->product))->markdown('emails.rfq.approval')->with(compact('rfq', 'sender'));
        if($rfq->send_image == 'YES'){
            $dir = 'document/rfq/' .$rfq->rfq_id.'/';
            $list = array_values(array_diff(scandir($dir, 0), array('..', '.')));
            if (count($list) > 0) {
                foreach ($list as $key) {
                    $mail->attach($dir.'/'.$key);
                }
            }
            
            $dir1 = 'document/rfq/' .$rfq->rfq_id.'/';
            $list1 = array_values(array_diff(scandir($dir1, 0), array('..', '.')));
            if (count($list1) > 0) {
                foreach ($list1 as $key1) {
                    $mail->attach($dir1.'/'.$key1);
                }
            }
        }
        
        if($tempFilePath != ""){
            $mail->attach($tempFilePath);
            }
        
        if($tempFileDirs != ""){
            // Attach files to the email
            for ($i = 0; $i < count($tempFileDirs); $i++) {
                $mail->attach($tempFileDirs[$i], ['as' => $fileNames[$i]]);
            }
        }
        
        
        // $mail->from($sender);
        return $mail;
    }
}

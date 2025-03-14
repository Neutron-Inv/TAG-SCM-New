<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupplierPO extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
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
        $user = $this->data['user'];
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
        $pricing = $this->data['pricing'];
        $company_id = $rfq->company_id;
        if ($company_id == 1) {
            $sender =  'contact@enabledsolutions.net';
            $reply = 'contact@enabledsolutions.net';
        } elseif ($company_id == 2) {
            $sender = 'sales@tagenergygroup.net';
            $reply = 'sales@tagenergygroup.net';
        } elseif ($company_id == 3) {
            $sender = 'contact@gloriousempiretech.com';
            $reply = 'contact@gloriousempiretech.com';
        } elseif ($company_id == 15) {
            $sender = 'contact@enabledgroup.net';
            $reply = 'contact@enabledgroup.net';
        } elseif ($company_id == 20) {
            $sender = 'sales@taglinesng.com';
            $reply = 'sales@taglinesng.net';
        } else {
            $name = cops($company_id);
            $sender = $name->email;
            $reply = $name->email;
        }
        $mail = $this->replyTo($reply, $company->company_name)->subject("Purchase Order for the Supply of " . $pricing->description . ": " . $rfqcode . " mail-id: " . $mail_id)->markdown('emails.po.SupplierPO')
            ->with(compact('rfq',  'user', 'extra_note', 'sender', 'reply', 'vendor_contact', 'pricing'));

        if ($tempFilePath != "") {
            $mail->attach($tempFilePath);
        }

        if ($tempFileDirs != "") {
            // Attach files to the email
            for ($i = 0; $i < count($tempFileDirs); $i++) {
                $mail->attach($tempFileDirs[$i], ['as' => $fileNames[$i]]);
            }
        }

        $mail->withSwiftMessage(function ($message) use ($mail_id) {
            $message->getHeaders()->addTextHeader('X-rfq-id', $mail_id);
        });

        // $mail->from($sender);
        return $mail;
    }
}

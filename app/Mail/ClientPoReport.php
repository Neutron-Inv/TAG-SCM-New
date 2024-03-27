<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientPoReport extends Mailable
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
        $clients = $this->data['clients'];
        $client = $this->data['client'];
        $client_id = $this->data['client_id'];
        $clients_det = $this->data['clients_det'];
        $mail = $this->subject($clients_det->client_name.' ' ."PO STATUS UPDATE")->markdown('emails.po.clientporeport')->with(compact('clients','client','client_id','clients_det'));
    }
}

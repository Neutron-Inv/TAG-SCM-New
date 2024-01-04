<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class POReport extends Mailable
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
        $client = $this->data['client'];
        $company = $this->data['company'];

        $company_name = $this->data['company_name'];
        $client_name = $this->data['client_name'];
        $po = $this->data['po'];
        $mail = $this->subject("PO REPORT FOR ".strtoupper($client->client_name))->markdown('emails.po.report')->with(compact('company','client', 'company_name', 'client_name', 'po'));
    }
}

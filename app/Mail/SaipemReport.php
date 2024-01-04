<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SaipemReport extends Mailable
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
        $saipem = $this->data['saipem'];
        $mail = $this->subject("TAG List of Saipem Bids as at - ".date('d-m-Y'))->markdown('emails.po.SaipemMonthly')->with(compact('saipem'));
    }
}

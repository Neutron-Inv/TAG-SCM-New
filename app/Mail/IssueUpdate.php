<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IssueUpdate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($issue, $by)
    {
        $this->issue = $issue;
        $this->by = $by;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $issue = $this->issue;
        $by = $this->by;
        return $this->subject('Re: Helpdesk Issue Update for '. $issue->category .' by '.$by)->markdown('emails.issues.issue-update')->with(compact('issue'));
    }
}

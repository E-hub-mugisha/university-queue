<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequestSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $serviceRequest;

    public function __construct($serviceRequest)
    {
        $this->serviceRequest = $serviceRequest;
    }

    public function build()
    {
        return $this->subject('Your Service Request Has Been Submitted')
            ->view('emails.request_submitted');
    }
}

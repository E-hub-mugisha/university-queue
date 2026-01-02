<?php

namespace App\Mail;

use App\Models\ServiceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequestRepliedMail extends Mailable
{
    public function __construct(public ServiceRequest $request) {}

    public function build()
    {
        return $this->subject('Update on Your Service Request')
            ->view('emails.request_reply');
    }
}

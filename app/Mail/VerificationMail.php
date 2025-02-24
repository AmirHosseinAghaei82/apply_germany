<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailCode;

    public $fullName;


    public function __construct($emailCode, $fullName)
    {

        $this->emailCode = $emailCode;

        $this->fullName = $fullName;
        
    }

    public function build()
    {

        return $this->view('emails.verify')
        ->with([
            'emailCode' => $this->emailCode,
            'fullName'  => $this->fullName
        ]);



    }

}

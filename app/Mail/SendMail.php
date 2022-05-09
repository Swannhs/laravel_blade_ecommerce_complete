<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject,$description;
    public function __construct($subject,$description)
    {
        $this->subject= $subject;
        $this->description= $description;
    }

    public function build()
    {
        return $this->view('emails.send_mail');
    }
}

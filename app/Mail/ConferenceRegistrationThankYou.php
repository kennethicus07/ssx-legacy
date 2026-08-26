<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConferenceRegistrationThankYou extends Mailable
{
    use Queueable, SerializesModels;

    public $registrationNumber;
    public $fullName;

    public function __construct($registrationNumber, $fullName)
    {
        $this->registrationNumber = $registrationNumber;
        $this->fullName = $fullName;
    }

    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('SSX Conference Registration Confirmation')
            ->view('emails.conference.registration_thank_you');
    }
}
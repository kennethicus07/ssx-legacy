<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConferenceRegistrationForAccounting extends Mailable
{
    use Queueable, SerializesModels;

    public $registrationNumber;
    public $companyName;
    public $contactPerson;
    public $companyEmail;
    public $finalAmount;

    public function __construct(
        $registrationNumber,
        $companyName,
        $contactPerson,
        $companyEmail,
        $finalAmount
    ) {
        $this->registrationNumber = $registrationNumber;
        $this->companyName = $companyName;
        $this->contactPerson = $contactPerson;
        $this->companyEmail = $companyEmail;
        $this->finalAmount = $finalAmount;
    }

    public function build()
    {
        return $this->from(
                env('MAIL_FROM_ADDRESS'),
                env('MAIL_FROM_NAME')
            )
            ->subject(
                'SSX Conference Registration For Accounting Review - ' .
                $this->registrationNumber
            )
            ->view('emails.conference.registration_for_accounting');
    }
}
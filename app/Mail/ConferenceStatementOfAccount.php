<?php

namespace App\Mail;

use App\Models\SSXConference;
use App\Models\Supplier\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConferenceStatementOfAccount extends Mailable
{
    use Queueable, SerializesModels;

    public $conference;
    public $fullName;
    public $soaPath;
    public $event;

    public function __construct(
        SSXConference $conference,
        string $soaPath,
        ?Event $event = null
    ) {
        $this->conference = $conference;
        $this->soaPath = $soaPath;
        $this->event = $event;

        $this->fullName = trim(
            ($conference->contact_person_salutation ?? '') . '. ' .
            ($conference->contact_person ?? '')
        );
    }

    public function build()
    {
        return $this
            ->view('emails.conference.statement-of-account')
            ->subject(
                'SSX Conference: Statement of Account'
            )
            ->with([
                'conference' => $this->conference,
                'fullName' => $this->fullName,
                'event' => $this->event,
                'eventName' =>  $this->event->event_name ?? "SSX Conference",
            ])
            ->attach(
                $this->soaPath,
                [
                    'as' => 'SSX-Statement-of-Account.pdf',
                    'mime' => 'application/pdf',
                ]
            );
    }
}


<?php

namespace App\Mail;

use App\Models\SSXConferenceDelegate;
use App\Models\Supplier\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConferenceDelegateApproved extends Mailable
{
    use Queueable, SerializesModels;

    private $delegate;
    private $event;

    public function __construct(
        SSXConferenceDelegate $delegate,
        ?Event $event = null
    ) {
        $this->delegate = $delegate;
        $this->event = $event;
    }

    public function build()
    {
        $fullName = trim(
            $this->delegate->salutation . '. ' .
            $this->delegate->fname . ' ' .
            $this->delegate->lname
        );

        return $this
            ->view('emails.conference.delegate-approved')
            ->subject(
                'SSX Conference: Delegate Confirmation and Session Registration'
            )
            ->with([
                'delegate' => $this->delegate,
                'fullName' => $fullName,
                'event' => $this->event,
                'event_name' => $this->event
                    ? $this->event->event_name
                    : 'SSX Conference',
                'event_dates' => $this->event
                    ? $this->event->formatted_date_range
                    : null,
                'location' => $this->event
                    ? $this->event->location
                    : null,
            ]);
    }
}
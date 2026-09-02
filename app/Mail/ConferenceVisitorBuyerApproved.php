<?php

namespace App\Mail;

use App\Models\SSXConferenceDelegate;
use App\Models\Supplier\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConferenceVisitorBuyerApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $delegate;
    public $fullName;
    public $event;

    /**
     * Create a new message instance.
     */
    public function __construct(
        SSXConferenceDelegate $delegate,
        ?Event $event = null
    ) {
        $this->delegate = $delegate;

        $this->fullName = trim(
            $delegate->salutation . '. ' .
            $delegate->fname . ' ' .
            $delegate->lname
        );

        $this->event = $event;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view(
            'emails.conference.visitor-buyer-approved'
        )
        ->subject(
            'SSX Conference: Visitor/Buyer Registration Confirmation'
        )
        ->with([
            'delegate' => $this->delegate,

            'fullName' => $this->fullName,

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
<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Supplier\ExhibitorAttendance;
use App\Models\Supplier\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupplierSoaSentNotfication extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $attendance;
    private $fairCode;
    private $event;

    public function __construct(User $user, ExhibitorAttendance $attendance, string $fairCode)
    {
        $this->user = $user;
        $this->attendance = $attendance;
        $this->fairCode = $fairCode;
        $this->event = Event::where('fair_code', $fairCode)->first();
    }

    public function build()
    {
        $viewData = [
            'user' => $this->user,
            'attendance' => $this->attendance,
            'fair_code' => $this->fairCode,
            'event_name' => $this->event ? $this->event->event_name : 'the event',
            'event_dates' => $this->event ? $this->event->formatted_date_range : null,
            'location' => $this->event ? $this->event->location : null,
        ];

        return $this->view('emails.soa.supplier-notification')
                    ->subject("Your Statement of Account (SOA) for {$viewData['event_name']} is now available")
                    ->with($viewData);
    }
}
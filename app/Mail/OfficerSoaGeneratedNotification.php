<?php

namespace App\Mail;

use App\Models\Supplier\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Supplier\ExhibitorAttendance;

class OfficerSoaGeneratedNotification extends Mailable
{
    use Queueable, SerializesModels;

  
    public $attendances;
    public $fairCode;
    private $event;

    /**

     * @param \Illuminate\Support\Collection|array $attendances
     * @param string $fairCode
     */
    public function __construct($attendances, string $fairCode)
    {

        $this->attendances = $attendances;
        $this->fairCode = $fairCode;
        $this->event = Event::where('fair_code', $fairCode)->first();
    }

    public function build()
    {
        return $this->subject("SOA Generated for Selected Companies - {$this->fairCode}")
                    ->view('emails.soa.officer-generated-notification')
                    ->with([
                     
                        'attendances' => $this->attendances,
                        'fair_code' => $this->fairCode,
                        'event_name' =>  $this->event->event_name,
                    ]);
    }
}
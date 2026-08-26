<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Event;
use App\Models\Supplier\Event as SupplierEvent;

class BuyerEmailRegistrationSuccess extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $event;

    /**
     * Create a new message instance.
     *
     * @param int $user_id
     * @param string $fair_code
     */
    public function __construct($user_id, $fair_code)
    {
        // Fetch user safely
        $this->user = User::findOrFail($user_id);

        // Fetch event by fair_code
        $this->event = SupplierEvent::where('fair_code', $fair_code)->first();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
           return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')) ->subject('Thank You for Submitting Your Application for '.$this->event->event_name)
                    ->view('emails.registration.buyer.success')
                    ->with([
                        'company_name' => $this->user->name,
                        'event_name' => $this->event->event_name ,
                    ]);
    }
}

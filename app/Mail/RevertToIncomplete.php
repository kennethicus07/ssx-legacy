<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use App\Models\Event;
use App\Models\Supplier\Event as SupplierEvent;

class RevertToIncomplete extends Mailable
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


    $reg_link = URL::temporarySignedRoute(
    'registration.buyer.steps', // route name
    now()->addDays(3),      // expiration: 3days
    ['token' => $this->user->reg_token] // route parameters
);
           return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')) ->subject('Your Registration Has Been Returned – Please Continue Your Registration')
                    ->view('emails.registration.returned')
                    ->with([
                        'reg_link' => $reg_link,
                        'company_name' => $this->user->name,
                        'event_name' => $this->event->event_name,
                    ]);
    }
}

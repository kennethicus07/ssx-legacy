<?php

namespace App\Mail;

use App\Models\Buyer;
use App\Models\Supplier\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class BuyerEmailRegistrationValidation extends Mailable
{
    use Queueable, SerializesModels;

    private $id;
    public $subject;
    public $fair_code;
    public $company_name;
    public $event_name;

    /**
     * Create a new message instance.
     *
     * @param int $id
     * @param string $subject
    * @param string $fair_code
    */
    public function __construct($id, $subject = 'SSX Email Validation', $fair_code)
    {
        $this->id = $id;
        $this->subject = $subject;
        $this->fair_code = $fair_code;

         $buyer = Buyer::where('uid', $id)
                      ->where('fair_code', $fair_code)
                      ->first();

        if ($buyer && $buyer->co_name) {
            $this->company_name = $buyer->co_name;
        } else {
            // fallback to user name
            $user = User::findOrFail($id);
            $this->company_name = $user->name;
        }

        $event = Event::where('fair_code', $fair_code)->first();
        $this->event_name = $event ? $event->event_name : '';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = User::findOrFail($this->id);

        // Ensure the user has a reg_token
        if (!$user->reg_token) {
            $user->reg_token = sha1(time());
            $user->save();
        }

        // $reg_link = URL::temporarySignedRoute(
        //     'registration.buyer.steps', // route name
        //     now()->addHours(24),        // expiration
        //     ['token' => $user->reg_token] // route parameters
        // );

        $reg_link = URL::temporarySignedRoute(
    'registration.buyer.steps', // route name
    now()->addDays(3),      // expiration: 3days
    ['token' => $user->reg_token] // route parameters
);

        Log::info('Buyer Registration Link: ' . $reg_link);

        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                    ->subject($this->subject)
                    ->view('emails.registration.buyer.email-validation')
                    ->with([
                        'reg_link' => $reg_link,
                        'company_name' => $this->company_name,
                        'fair_code'    => $this->fair_code,
                        'event_name'   => $this->event_name,
                    ]);
    }
}

<?php

namespace App\Mail;

use App\Models\Buyer;
use Illuminate\Bus\Queueable;
use App\Models\Supplier\Event;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;


class BuyerApprovedApplication extends Mailable
{
    use Queueable, SerializesModels;

   
    private $user;
    private $buyer;
    private $fairCode;
    private $event;

    /**
     * Create a new message instance.
     * @param User $user
     * @param Buyer $buyer
     * @param string $fairCode
     */

  public function __construct(User $user, Buyer $buyer,string $fairCode)
    {
        $this->user = $user;
        $this->buyer = $buyer;
        $this->fairCode = $fairCode;
        $this->event = Event::where('fair_code', $fairCode)->first();
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         $viewData = [
            'user' => $this->user,
            'buyer' => $this->buyer,
            'fair_code' => $this->fairCode,
            'event_name' => $this->event ? $this->event->event_name : 'the event',
            'event_dates' => $this->event ? $this->event->formatted_date_range : null,
            'location' => $this->event ? $this->event->location : null,
        ];

           $email = $this->view('emails.registration.buyer.approved')
            ->subject("Congratulations! You are now a Purchaser/Buyer of {$this->event->event_name}!")
            ->with($viewData);

        return $email;
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OfficerPaymentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $attendances;

    /**
     * Create a new message instance.
     *
     * @param array|\Illuminate\Support\Collection $attendances
     */
    public function __construct($attendances)
    {
        $this->attendances = $attendances;
    }

public function build()
{
    $subject = 'Payment Paid - List of Companies'; // clearer wording

    return $this->subject($subject)
                ->view('emails.payment.officer-payment-notification');
}
}
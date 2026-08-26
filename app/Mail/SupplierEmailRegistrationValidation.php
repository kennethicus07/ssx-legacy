<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Support\Facades\URL;

class SupplierEmailRegistrationValidation extends Mailable
{
    use Queueable, SerializesModels;

    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function build()
    {
        $user = User::findOrFail($this->id);
        $subject = 'SSX Supplier Email Validation';

        // $verifyUrl = URL::temporarySignedRoute(
        //     'verification.supplier.verify',
        //     now()->addMinutes(60),
        //     ['id' => $user->id]
        // );

                $verifyUrl = URL::signedRoute(
            'verification.supplier.verify',
            ['id' => $user->id]
        );


        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                    ->subject($subject)
                    ->view('emails.registration.supplier.email-validation')
                    ->with(['verifyUrl' => $verifyUrl]);
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\User;

class EmailRegistrationValidation extends Mailable
{
    use Queueable, SerializesModels;

    private $id;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = User::findOrFail($this->id);
        
        $subject = 'SSX Email Validation';
        
        $reg_link = route('registration.exhibitor.steps', [$user->reg_token]);

        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                    ->subject($subject)
                    ->view('emails.registration.exhibitor.email-validation')
                    ->with([
                        'reg_link' => $reg_link,
                    ]);
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\User;

class ResetPassword extends Mailable
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

        if ($user->user_group === 2) {
            $fname = $user->business_owner->fname;
        } elseif ($user->user_group === 3) {
            $fname = $user->buyer->fname;
        } else {
            $fname = $user->name;
        }
        
        $subject = 'SSX reset password request';
        
        $reset_link = route('auth.reset.password', ['token' => $user->reset_password_token]);

        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                    ->subject($subject)
                    ->view('emails.reset-password')
                    ->with([
                        'fname' => $fname,
                        'reset_link' => $reset_link,
                    ]);
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\User;

class DeniedApplication extends Mailable
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
        $fname = '';
        
        if ($user->user_group === 5) {
            $group = 'Supplier';
            if (!empty($user->exhibitor)) {
                $fname = $user->exhibitor->co_name;
            }
        } else {
            $group = 'Buyer';
            $fname = $user->buyer->fname;
        }
        
        $subject = 'Sorry! Your SSX Application has been denied​';

        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                    ->subject($subject)
                    ->view('emails.registration.denied')
                    ->with([
                        'fname' => ucwords($fname),
                        'group' => $group,
                    ]);
    }
}

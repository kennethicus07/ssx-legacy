<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\User;

class OnHoldApplication extends Mailable
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
        
        if ($user->user_group === 2) {
            $group = 'Supplier';
            if (!empty($user->exhibitor)) {
                $fname = $user->exhibitor->co_name;
            }
        } else {
            $group = 'Buyer';
            $fname = $user->buyer->fname;
        }
        
        $subject = 'Sorry! Your SSX Application is put on hold.​';

        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                    ->subject($subject)
                    ->view('emails.registration.onhold')
                    ->with([
                        'fname' => ucwords($fname),
                        'group' => $group,
                    ]);
    }
}

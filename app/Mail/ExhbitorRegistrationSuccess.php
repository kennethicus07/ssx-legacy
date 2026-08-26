<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ExhbitorRegistrationSuccess extends Mailable
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

        $subject = 'Your SSX Application has been received.​';

        $filename = $user->exhibitor->slug.'_'.$user->id.'.pdf';
        $summary_path = public_path('storage/exhibitor_summary/'.$filename);

        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->subject($subject)
                ->view('emails.registration.exhibitor.success')
                ->attach($summary_path, [
                    'as' => $filename,
                    'mime' => 'application/pdf',
                ])
                ->with([
                    'fname' => ucwords($user->business_contact_person->fname)
                ]);
    }
}

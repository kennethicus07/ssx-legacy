<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUs extends Mailable
{
    use Queueable, SerializesModels;

    private $info = [];
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($info)
    {
        $this->info = $info;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Message from inquiry from in SSX website';

        return $this->from(strtolower($this->info['email']), ucwords($this->info['fullname']))
                ->subject($subject)
                ->view('emails.contact-us')
                ->with([
                    'info' => $this->info
                ]);
    }
}

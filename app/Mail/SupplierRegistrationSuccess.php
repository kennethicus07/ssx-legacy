<?php

namespace App\Mail;

use App\Models\Exhibitor;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SupplierRegistrationSuccess extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $exhibitor;
    private $fair_code;
    private $event_name;
    private $pdfPath;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param Exhibitor $exhibitor
     * @param string $fair_code
     * @param string $event_name
     * @param string|null $pdfPath Full path to the generated PDF
     */
    public function __construct(User $user, Exhibitor $exhibitor, string $fair_code, string $event_name, ?string $pdfPath = null)
    {
        $this->user = $user;
        $this->exhibitor = $exhibitor;
        $this->fair_code = $fair_code;
        $this->event_name = $event_name;
        $this->pdfPath = $pdfPath;
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
            'exhibitor' => $this->exhibitor,
            'fair_code' => $this->fair_code,
            'event_name' => $this->event_name,
            'fname' => $this->user->name,
        ];

        $email = $this->view('emails.registration.supplier.success')
            ->subject("Registration Confirmation for {$this->event_name}")
            ->with($viewData);

        // Attach PDF if it exists
        // if ($this->pdfPath && file_exists($this->pdfPath)) {
        //     $email->attach($this->pdfPath, [
        //         'as' => basename($this->pdfPath),
        //         'mime' => 'application/pdf',
        //     ]);
        // }

        return $email;
    }
}

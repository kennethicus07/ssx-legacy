<?php

namespace App\Mail;

use App\Models\Supplier\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Exhibitor;


class SupplierConformeValidation extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $exhibitor;
    private $fairCode;
    private $event;
    private $pdfPath;
    private $token; 
    /**
     * Create a new message instance.
     * @param User $user
     * @param Exhibitor $exhibitor
     * @param string $fairCode
     * @param string|null $pdfPath 
     * @param string|null $token
     */
    public function __construct(User $user, Exhibitor  $exhibitor,string $fairCode,  ?string $pdfPath = null, $token = null)
    {
        $this->user = $user;
        $this->exhibitor = $exhibitor;
        $this->fairCode = $fairCode;
        $this->event = Event::where('fair_code', $fairCode)->first();
        $this->pdfPath = $pdfPath;
        $this->token = $token;
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
            'fair_code' => $this->fairCode,
            'event_name' => $this->event ? $this->event->event_name : null,
            'pdf_failed' => !$this->pdfPath || !file_exists($this->pdfPath),
            'pdfFilename' => $this->pdfPath ? basename($this->pdfPath) : null,
            'token' => $this->token, 
        ];

           $email = $this->view('emails.registration.supplier.conforme_validation')
            ->subject("Congratulations! You are now a Supplier/Exhibitor of {$this->event->event_name}!")
            ->with($viewData);

        // if ($this->pdfPath && file_exists($this->pdfPath)) {
        //     $email->attach($this->pdfPath, [
        //         'as' => basename($this->pdfPath),
        //         'mime' => 'application/pdf',
        //     ]);
        // }

        return $email;
    }
}

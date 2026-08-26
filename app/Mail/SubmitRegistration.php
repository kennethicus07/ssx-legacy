<?php

namespace App\Mail;

use App\Models\Supplier\Event;
use App\Models\Exhibitor;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubmitRegistration extends Mailable
{
    use Queueable, SerializesModels;

    private User $user;
    private ?Exhibitor $exhibitor;
    private Event $event;

    private string $exhibitorEmail;
    private string $buyerEmail;
    private string $friendlyGroup;
    
    /**
     * Create a new message instance.
     * @param User $user
     * @param Exhibitor|null $exhibitor
     * @param Event $event
     *
     * @return void
     */
   public function __construct(User $user, ?Exhibitor $exhibitor, Event $event)
{
    $this->user = $user;
    $this->exhibitor = $exhibitor;
    $this->event = $event;

    // Friendly group text
    $this->friendlyGroup = $user->user_group === 5
        ? 'Supplier/Exhibitor'
        : 'Purchaser/Buyer';

    if ($user->user_group === 5) {
        // Supplier/Exhibitor must have exhibitor email
        if (!$exhibitor || empty($exhibitor->co_email)) {
            throw new \InvalidArgumentException("Exhibitor or its email is missing for Supplier user {$user->id}");
        }
        $this->exhibitorEmail = $exhibitor->co_email;
        $this->buyerEmail = ''; // not needed
    } else {
        // Purchaser/Buyer must have buyer email
        $buyer = $user->buyerForFair($event->fair_code);
        if (!$buyer || empty($buyer->co_email)) {
            throw new \InvalidArgumentException("Buyer or its email is missing for Purchaser user {$user->id}");
        }
        $this->buyerEmail = $buyer->co_email;
        $this->exhibitorEmail = ''; // not needed
    }
}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Determine company name dynamically
        $companyName = $this->exhibitor
            ? $this->exhibitor->co_name
            : $this->user->buyerForFair($this->event->fair_code)->co_name;

        // Professional, clear subject
        $subject = "Submitted Registration: {$this->friendlyGroup} Application of {$companyName} for "
            . ($this->event->event_name ?? 'the event');

        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                    ->subject($subject)
                    ->view('emails.registration.submit_registration')
                    ->with([
                        'companyName'    => $companyName,
                        'group'          => $this->friendlyGroup,
                        'event'          => $this->event,
                        'exhibitorEmail' => $this->exhibitorEmail,
                        'buyerEmail'     => $this->buyerEmail,
                    ]);
    }
}

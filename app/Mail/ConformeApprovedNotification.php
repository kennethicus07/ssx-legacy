<?php

namespace App\Mail;

use App\Models\Conforme;
use App\Models\Exhibitor;
use App\Models\Supplier\Event as SupplierEvent;
use App\Models\Supplier\ExhibitorAttendance;
use App\Models\ExhibitorBusinessContactPerson;
use App\Models\ExhibitorBusinessOwner;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConformeApprovedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;      
    public $exhibitor;  
    public $event;     
    public $attendance;  
    public $conforme;  
    public $businessOwner; 
     public $businessContactPerson; 
    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param Exhibitor $exhibitor
     * @param SupplierEvent $event
     * @param ExhibitorAttendance $attendance
     * @param Conforme $conforme
     */
    public function __construct(User $user, Exhibitor $exhibitor, SupplierEvent $event, ExhibitorAttendance $attendance, Conforme $conforme)
    {
        $this->user = $user;
        $this->exhibitor = $exhibitor;
        $this->event = $event;
        $this->attendance = $attendance;
        $this->conforme = $conforme;

        $this->businessOwner = ExhibitorBusinessOwner::where('fair_code', $event->fair_code)
        ->where('uid', $user->id)
        ->first();

        $this->businessContactPerson = ExhibitorBusinessContactPerson::where('fair_code', $event->fair_code)
        ->where('uid', $user->id)
        ->first();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Supplier/Exhibitor \"{$this->user->name}\" Approved Conforme for {$this->event->event_name}";

        return $this->subject($subject)
                    ->view('emails.registration.supplier.conforme_approved')->with([
                    'exhibitor_name'  => $this->user->name,
                    'exhibitor_email' => $this->user->email,
                    'event_name' => $this->event->event_name,
                    'conforme_officer' => $this->attendance->conforme_officer->name,
                    'reviewer_officer' => $this->exhibitor->reviewer->name,
                    'business_owner_name' => $this->businessOwner
                    ? $this->businessOwner->fname 
                    . ($this->businessOwner->mi ? ' ' . $this->businessOwner->mi : '') 
                    . ' ' . $this->businessOwner->lname
                    : 'N/A', 
                    'business_owner_email'=> $this->businessOwner->email ?? 'N/A',
                    'business_owner_designation'=> $this->businessOwner->designation ?? 'N/A',
                    'business_owner_mobile'=> $this->businessOwner->mobile_no ?? 'N/A',
                    'business_contact_person_name' => $this->businessContactPerson
                    ? $this->businessContactPerson->fname 
                    . ($this->businessContactPerson->mi ? ' ' . $this->businessOwner->mi : '') 
                    . ' ' . $this->businessContactPerson->lname
                    : 'N/A', 
                    'business_contact_person_email'=> $this->businessContactPerson->email ?? 'N/A',

                    'business_contact_person_designation'=> $this->businessContactPerson->email ?? 'N/A',
                    'business_contact_person_mobile'=> $this->businessContactPerson->mobile_no ?? 'N/A',
                ]);
    }
}

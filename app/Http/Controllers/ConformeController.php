<?php

namespace App\Http\Controllers;

use App\Mail\ConformeApprovedNotification;
use App\Mail\ConformeRejectedNotification;
use Illuminate\Http\Request;
use App\Models\Conforme;
use App\Models\Supplier\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class ConformeController extends Controller
{

private function parseEmailList($value)
{
if (!$value) {
    return [];
}

// Convert comma-separated string into array
$emails = is_array($value) ? $value : explode(',', $value);

// Trim & filter
return array_values(array_filter(array_map('trim', $emails)));
}

protected function touchExhibitor($user, $event_fair_code)
{
if (! $exhibitor = $user->exhibitor()->where('fair_code', $event_fair_code)->first()) {
    return;
}

$exhibitor->touch();
}

public function handle_conforme_response($token, $status)
{
    // Find the record by token
    $conforme = Conforme::where('email_token', $token)->first();

    if (!$conforme) {
        return redirect()->route('home')->with('error', 'Invalid or expired link.');
    }

    // ff_code is your user_id
    $user = User::find($conforme->ff_code);
    $fair_code = $conforme->fair_code;

    $exhibitor = null;
    $attendance = null;

    if ($user) {
        $exhibitor  = $user->exhibitorForFair($fair_code);
        $attendance = $user->exhibitorAttendanceForFair($fair_code);
        $event = Event::where('fair_code', $fair_code)->first();
    }

if ($conforme->response !== null) {
    // Already responded
    $statusMessage = 2; // 2 = already responded
} else {
    // Save new response
    $conforme->response = $status;
    $conforme->date_responded = Carbon::now();
    $conforme->save();

if ($attendance) {
        if ($status == 0) {
            // Reject
            $this->handleConformeRejection($user, $exhibitor, $event, $attendance, $conforme);
        } elseif ($status == 1) {
            // Approve
            $this->handleConformeApproval($user, $exhibitor, $event, $attendance, $conforme);
        }
    }


    $statusMessage = $status; // 1 = approve, 0 = not approve
}

// Return to Blade
return view('website.conforme.response', [
    'statusMessage' => $statusMessage
]);

}

private function handleConformeApproval($user, $exhibitor, $event, $attendance, $conforme)
{
    // Example approval status — adjust if needed
    // $attendance->status = 1; 
    // $attendance->save();

    $this->touchExhibitor($user, $conforme->fair_code);

    // MAIN to
    $to = $exhibitor->reviewer->email;
   

    // CC 
    $cc = [];
    if ($attendance->conforme_officer) {
        $cc = $this->parseEmailList($attendance->conforme_officer->email);
    }

    // BCC list
 $bcc = $this->parseEmailList(env('BCC_Officer_Suppliers'));
   
    if ($to) {

        if (env('APP_ENV') != 'local') {

            Mail::to($bcc)
                ->send(new ConformeApprovedNotification(
                    $user, $exhibitor, $event, $attendance, $conforme
                ));

        } else {

            Mail::to('kgtecson.citem@gmail.com')
                ->cc($cc)
                ->send(new ConformeApprovedNotification(
                    $user, $exhibitor, $event, $attendance, $conforme
                ));
        }
    }
}

private function handleConformeRejection($user, $exhibitor, $event, $attendance, $conforme)
{
    // Update status
    $attendance->status = 2; 
    $attendance->conforme_review = null;
    $attendance->save();

    $this->touchExhibitor($user, $conforme->fair_code);

    // MAIN to
    $to = 
         $attendance->conforme_officer->email;
        

    // CC reviewer
    $cc = [];
    if ($exhibitor->reviewer) {
        $cc = $this->parseEmailList($exhibitor->reviewer->email);
    }

    // BCC list
 $bcc = $this->parseEmailList(env('BCC_Officer_Suppliers'));

    // Send email
    if ($to) {
        if (env('APP_ENV') != 'local') {

            Mail::to($bcc)
                ->send(new ConformeRejectedNotification(
                    $user, $exhibitor, $event, $attendance, $conforme
                ));

        } else {

            Mail::to('kgtecson.citem@gmail.com')
                ->cc($cc)
                ->send(new ConformeRejectedNotification(
                    $user, $exhibitor, $event, $attendance, $conforme
                ));
        }
    }
}

}
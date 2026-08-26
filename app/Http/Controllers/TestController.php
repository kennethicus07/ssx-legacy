<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SSXConference;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\CompleteConferenceRegistration;

class TestController extends Controller
{
    //

    // public function testView2() {
    //     // $conf = SSXConference::find(698);
    //     $conf = SSXConference::with(['conferenceBreakdown' => function($query){
    //         $query->where('type', 'discount');
    //     }])->find(5341);

    //     if(!$conf) {
    //         return "Not Found";
    //     }

    //     $timestamp = now()->format('Ymd_His');
    //     $or_filename = $conf->billing_file;
    //     $pdf = Pdf::loadView('emails.conference.conference-billing', ['conf' => $conf])
    //         ->setPaper('a4', 'portrait')
    //         ->save('conference/billing/' . $or_filename);


    //     return view('emails.conference.conference-billing', ['conf' => $conf]);
    // }

    // public function testSend() {

    //     $conference = SSXConference::find(5341);
    //     $billing_statment = env('APP_URL') . '/conference/billing/' . $conference->billing_file;

    //     Mail::to(strtolower($conference->company_email))->bcc(['nogidlayan@citem.com.ph','nogidlayan.citem@gmail.com'])->send(new CompleteConferenceRegistration($billing_statment));

    //     return "5341 Sent";
    // }

    // public function testView() {
    //     return view('emails.conference.registration_complete');
    // }
}

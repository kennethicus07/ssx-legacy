<?php

namespace App\Exports;

use App\Models\SSXConferenceDelegate;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DelegateCertificationsExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $request = $this->request;

        $query = SSXConferenceDelegate::with('conference');

        /*
        |--------------------------------------------------------------------------
        | Registration Number
        |--------------------------------------------------------------------------
        */
        if ($request->filled('registration_number')) {
            $query->whereHas('conference', function ($q) use ($request) {
                $q->where(
                    'registration_number',
                    'like',
                    '%' . $request->registration_number . '%'
                );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Company
        |--------------------------------------------------------------------------
        */
        if ($request->filled('company_name')) {
            $query->whereHas('conference', function ($q) use ($request) {
                $q->where(
                    'company_name',
                    'like',
                    '%' . $request->company_name . '%'
                );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Contact Person
        |--------------------------------------------------------------------------
        */
        if ($request->filled('contact_person')) {
            $query->whereHas('conference', function ($q) use ($request) {
                $q->where(function ($subQuery) use ($request) {
                    $subQuery
                        ->where(
                            'fname',
                            'like',
                            '%' . $request->contact_person . '%'
                        )
                        ->orWhere(
                            'lname',
                            'like',
                            '%' . $request->contact_person . '%'
                        );
                });
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Contact Email
        |--------------------------------------------------------------------------
        */
        if ($request->filled('company_email')) {
            $query->whereHas('conference', function ($q) use ($request) {
                $q->where(
                    'company_email',
                    'like',
                    '%' . $request->company_email . '%'
                );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Fair Code
        |--------------------------------------------------------------------------
        */
        if ($request->filled('fair_code')) {
            $query->whereHas('conference', function ($q) use ($request) {
                $q->where(
                    'fair_code',
                    $request->fair_code
                );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */
if ($request->filled('status')) {
    $query->whereHas('conference', function ($q) use ($request) {
        $q->where('status', $request->status);
    });
}

        return $query
            ->orderBy('id', 'asc')
            ->get()
            ->map(function ($delegate) {

                /*
                |--------------------------------------------------------------------------
                | Participant Type
                |--------------------------------------------------------------------------
                |
                | Priority:
                | 1. Visitor / Buyer
                | 2. Speaker
                | 3. Regular Delegate
                |
                |--------------------------------------------------------------------------
                */

                if ((int) $delegate->is_visitor_buyer === 1) {
                    $participantType = 'Visitor / Buyer';
                } elseif ((int) $delegate->is_speaker === 1) {
                    $participantType = 'Speaker';
                } else {
                    $participantType = 'Delegate';
                }

                return [
                    $participantType,

                    $delegate->conference
                        ? $delegate->conference->registration_number
                        : '',

                    $delegate->conference
                        ? $delegate->conference->fair_code
                        : '',

                        $delegate->conference
                        ? $delegate->conference->certificate
                        : '',

                    $delegate->salutation,

                    $delegate->fname,

                    $delegate->lname,

                    $delegate->country,

                    $delegate->designation,

                    $delegate->email,

                    $delegate->country_code_mobile,

                    $delegate->mobile_no,

          

                    $delegate->addtnl_type,

                    (int) $delegate->senior === 1
                        ? 'Yes'
                        : 'No',

                    (int) $delegate->pwd === 1
                        ? 'Yes'
                        : 'No',

                    $delegate->delegateCategoryText(),


                    $delegate->delegate_category_other,
                ];
            });
    }

    /**
     * Excel headings
     */
    public function headings(): array
    {
        return [
            'Participant Type',
            'Registration Number',
            'Event',
            'Certificate',
            'Salutation',
            'First Name',
            'Last Name',
            'Country',
            'Designation',
            'Email',
            'Country Code',
            'Mobile No.',
        
            'Additional Type',
            'Senior',
            'PWD',
            'Delegate Category',
            'Delegate Category Other',
        ];
    }
}
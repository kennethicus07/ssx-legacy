<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SSXConferenceDelegate extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'ssx_conference_delegates';
    
    public const CATEGORY_DECISION_MAKER = 1;
    public const CATEGORY_RECOMMENDING_OFFICER = 2;
    public const CATEGORY_TECHNICAL_REPRESENTATIVE = 3;
    public const CATEGORY_OTHER = 99;

    public const CATEGORY_LABELS = [
    self::CATEGORY_DECISION_MAKER => 'Decision-maker',
    self::CATEGORY_RECOMMENDING_OFFICER => 'Recommending Officer',
    self::CATEGORY_TECHNICAL_REPRESENTATIVE => 'Technical Representative',
];

    protected $fillable = [
        'ssx_conference_id',
        'qr_token',
        'qr_file',
        'salutation',
        'fname',
        'lname',
        'country',
        'designation',
        'email',
        'country_code_mobile',
        'mobile_no',
        'is_speaker',
        'is_visitor_buyer',
        'addtnl_type',
        'senior',
        'is_email_sent',
        'email_sent_at',
        'pwd',
        'id_file',
        'delegate_category',
        'delegate_category_other',
    ];

    protected $casts = [
        'is_speaker' => 'boolean',
        'is_visitor_buyer' => 'boolean',
        'senior' => 'boolean',
        'pwd' => 'boolean',
        'is_email_sent' => 'boolean',
        'email_sent_at' => 'datetime',
    ];


public function delegateCategoryText()
{
    if ((int) $this->delegate_category === self::CATEGORY_OTHER) {
        return $this->delegate_category_other ?: 'Other';
    }

    return self::CATEGORY_LABELS[$this->delegate_category] ?? '-';
}

    public function conference() {
        return $this->belongsTo(SSXConference::class, 'ssx_conference_id');
    }

 
}

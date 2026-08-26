<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IFEXConferenceCode extends Model
{
    use HasFactory;

    protected $connection = 'mysql_ifex';
    protected $table = 'ifexconn_db.ssx_conference_codes';
}

<?php

namespace App\Modules\InternalEvent\Promo\Controllers\Admin\Blade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PromoUserController extends Controller
{
    public function index()
    {
        return view('admin.promo_codes.emails.index');
    }


}




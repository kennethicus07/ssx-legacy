<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard.index');
    }

    public function website_cache()
    {
        return view('admin.dashboard.cache');
    }
}

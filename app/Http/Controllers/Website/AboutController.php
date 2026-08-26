<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\Event;
use Meta;

class AboutController extends Controller
{
    public function index()
    {
        $seconds = 86400; //1 Day

        $featured_event = cache()->remember('featured_events', $seconds, function () {
            return Event::where('is_featured', 1)->where('status', 1)->first(); 
        });

        $educate_event = cache()->remember('educate_event', $seconds, function () {
            return Event::where('is_educate', 1)->where('status', 1)->first(); 
        });

        $meta_tag = DB::table('seo_meta_tags_pages')->where('page', '=', 'about-ssx')->first();
        
        Meta::title($meta_tag->meta_title);
        Meta::set('robots', $meta_tag->meta_robots);
        Meta::set('keywords', $meta_tag->meta_keywords);
        Meta::set('description', $meta_tag->meta_description);
        if (!empty($meta->meta_author)) {
            Meta::set('author', $meta_tag->meta_author);
        }
        if (!empty($meta->meta_image)) {
            Meta::set('image', asset('storage/app/public/meta_images/'.$meta->meta_image));
        }
        Meta::set('canonical', url()->current());

        return view('website.about-us.index', compact('featured_event','educate_event'));
    }
}

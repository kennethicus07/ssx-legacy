<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Event;
use App\Models\Article;
use Carbon\Carbon;
use Meta;

class EventController extends Controller
{
    public function index()
    {
        $seconds = 86400; //1 Day
        $curr_date = Carbon::now();

        $event_top1 = cache()->remember('event_top1', $seconds, function () use ($curr_date) {
            // return Event::where('status', 1)->where('event_date_1', '>', $curr_date)->first();
            return Event::where('status', 1)->latest()->first();
        });

        if($event_top1 && $event_top1->id) {
            $event_top2 = cache()->remember('event_top2', $seconds, function () use ($curr_date, $event_top1) { 
                // return Event::where('status', 1)->where('event_date_1', '>', $curr_date)->where('id', '!=', $event_top1->id)->first();
                $event2 = Event::where('status', 1)->latest()->where('id', '!=', $event_top1->id)->first();
            });
        }
        else {
            $event_top2 = null;
        }
        
        if($event_top1 && $event_top1->id && $event_top2 && $event_top2->id) {
            $event_top3 = cache()->remember('event_top3', $seconds, function () use ($curr_date, $event_top1, $event_top2) {
                // return Event::where('status', 1)->where('event_date_1', '>', $curr_date)->whereNotIn('id', [$event_top1->id, $event_top2->id])->first();
                return Event::where('status', 1)->latest()->whereNotIn('id', [$event_top1->id, $event_top2->id])->first();
            });
        }
        else {
            $event_top3 = null;
        }

        $latest_events = cache()->remember('latest_events', $seconds, function () use ($curr_date) {
            // return Event::where('status', 1)->where('event_date_1', '>', $curr_date)->latest()->take(10)->get();
            return Event::where('status', 1)->latest()->take(10)->get();
        });
        $upcoming_events = cache()->remember('upcoming_events', $seconds, function () use ($curr_date) {
            // return Event::where('status', 1)->where('event_date_1', '>', $curr_date)->get();
            return Event::where('status', 1)->latest()->get();
        });
        $local_events = cache()->remember('local_events', $seconds, function () {
            return Event::where('status', 1)->where('event_happening', '=', 'local')->get();
        });
        $global_events = cache()->remember('global_events', $seconds, function () {
            return Event::where('status', 1)->where('event_happening', '=', 'global')->get();
        });
        
        $articles = cache()->remember('latest-articles', $seconds, function () {
            return Article::where('status', 1)->latest()->take(8)->get(); 
        });

        $meta_tag = DB::table('seo_meta_tags_pages')->where('page', '=', 'events-activities')->first();
        
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
        
        return view('website.event.index', [
            'event_top1' => $event_top1, 
            'event_top2' => $event_top2, 
            'event_top3' => $event_top3,
            'latest_events' => $latest_events,
            'upcoming_events' => $upcoming_events,
            'local_events' => $local_events,
            'global_events' => $global_events,
            'articles' => $articles,
        ]);
    }

    public function showInfo(){
        return view('website.event.show-info');
    }

    public function sdg2025(){
        return view('website.event.trade_fairs.sdg_2025.index');
    }

    public function sdg2026(){
        return view('website.event.trade_fairs.sdg_2026.index');
    }

    public function conference_and_exhibition(){
        return  view('website.event.conference_and_exhibition');
    }
}

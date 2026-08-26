<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Event;
use App\Models\Article;
use App\Models\Carousel;
use App\Models\Page;
use Carbon\Carbon;
use Meta;

class HomeController extends Controller
{
    public function index()
    {
        $seconds = 86400; //1 Day
        
        $arr_articles = [];
        $latest_articles = cache()->remember('latest-articles', $seconds, function () {
            $articles =  Article::where('status', 1)->where('article_type', '=', 'news-articles')->latest()->take(10)->get(); 
            foreach ($articles as $article) {
                $image_thumb = check_file_exist('articles/thumbs/', 'thumb', $article->image_thumb);
                $arr_articles[] = [
                    'id' => $article->id,
                    'title' => $article->title,
                    'intro' => Str::limit($article->sub_title, 70),
                    'thumb' => $image_thumb,
                    'url' => route('news-articles.details', [$article->slug]),
                    'tags' => $article->category_tag
                ];
            }
            return $arr_articles;
        });
        
        //dd($latest_articles);
        $featured_event = Event::where('is_featured', 1)->where('status', 1)->first();

        $educate_event = Event::where('is_educate', 1)->where('status', 1)->first(); 
        
        
        $latest_events = cache()->remember('up-coming-events', $seconds, function () {
            
            $arr_events = [];

            // $events = Event::where('status', 1)->where('event_date_1', '>', Carbon::now())->take(10)->get(); 
            $events = Event::where('status', 1)->latest()->take(10)->get(); 
            if($events) {
                foreach ($events as $event) {
                    $image_thumb = check_file_exist('events/thumbs/', 'thumb', $event->event_banner);
                    if ($event->event_type == 'digital') {
                        $event_type = $event->platform;
                    } else {
                        $event_type = $event->location;
                    }
                    $image_logo = check_file_exist('events/organizer_logos/', 'logo', $event->organizer_logo);
                    $arr_events[] = [
                        'id' => $event->id,
                        'title' => $event->title,
                        'type' => $event_type,
                        'organizer_name' => $event->organizer,
                        'organizer_logo' => $image_logo,
                        'thumb' => $image_thumb,
                        'url' => $event->event_link,
                        'tags' => $event->category_tag
                    ];
                }
            }
            
            return $arr_events;
        });

        // $banners = cache()->rememberForever('home-carousel-banners', function () {
        //     return Carousel::where('status', 1)->latest()->get();
        // });
        $banners = Carousel::where('status', 1)->latest()->get();

        $meta_tag = DB::table('seo_meta_tags_pages')->where('page', '=', 'homepage')->first();
        
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

        return view('website.home.index', compact('latest_articles','latest_events', 'banners', 'featured_event', 'educate_event'));
    }

    
    

    



    public function page($slug)
    {
        $page = Page::where('slug', '=', $slug)->where('status', 1)->firstOrFail();

        Meta::title($page->meta_title);
        Meta::set('robots', env('META_ROBOTS'));
        Meta::set('keywords', $page->meta_keywords);
        Meta::set('description', $page->meta_description);
        Meta::set('author', 'CITEM');
        Meta::set('canonical', url()->current());

        return view('website.home.page', compact('page'));
    }

    public function search($keyword) {

        $meta_tag = DB::table('seo_meta_tags_pages')->where('page', '=', 'sitewide-search')->first();
        
        Meta::title($meta_tag->meta_title);
        Meta::set('robots', $meta_tag->meta_robots);
        Meta::set('keywords', $meta_tag->meta_keywords);
        Meta::set('description', $meta_tag->meta_description);
        Meta::set('author', $meta_tag->meta_author);
        Meta::set('canonical', url()->current());

        return view('website.home.search', compact('keyword'));
    }

    public function sitemap()
    {
        $meta_tag = DB::table('seo_meta_tags_pages')->where('page', '=', 'sitemap')->first();
        
        Meta::title($meta_tag->meta_title);
        Meta::set('robots', $meta_tag->meta_robots);
        Meta::set('keywords', $meta_tag->meta_keywords);
        Meta::set('description', $meta_tag->meta_description);
        Meta::set('author', $meta_tag->meta_author);
        Meta::set('canonical', url()->current());

        return view('website.home.sitemap');
    }

    public function sitemap_xml()
    {
        $time_now = Carbon::now()->toIso8601String();

        $suppliers = User::where('status', 1)->where('user_group', 2)->where('solution_type', '=', 'marketplace')->get();
        $sustainables = User::where('status', 1)->where('user_group', 2)->where('solution_type', '=', 'sustainable')->get();
        $intelligences = Article::where('status', 1)->where('article_type', '=', 'solutions-intelligence')->get();
        $offers = Article::where('status', 1)->where('article_type', '=', 'programs-offers')->get();
        $articles = Article::where('status', 1)->where('article_type', '=', 'news-articles')->get();

        $data = [
            'time_now' => $time_now,
            'suppliers' => $suppliers,
            'sustainables' => $sustainables,
            'intelligences' => $intelligences,
            'offers' => $offers,
            'articles' => $articles,
        ];

        return response()->view('website.home.sitemap_xml', $data, 200)->header('Content-Type', 'text/xml');
    }

    public function serviceRedirect() {
        return view('website.service-redirect');
    }

    public function privacy_policy(){
        return view('website.privacy-policy.index');
    }
}

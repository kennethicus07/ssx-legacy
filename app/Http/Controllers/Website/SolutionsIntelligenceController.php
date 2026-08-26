<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use App\Models\Article;
use Meta;

class SolutionsIntelligenceController extends Controller
{
    public function index()
    {
        $seconds = 86400; //1 Day
        
        $latest_articles = cache()->remember('articles-'.Str::random(10), $seconds, function () {
            return Article::where('status', 1)->where('article_type', '=', 'solutions-intelligence')->latest()->take(3)->get(); 
        });

        $featured_article = cache()->remember('articles-'.Str::random(10), $seconds, function () {
            return Article::where('status', 1)->where('is_featured', 1)->where('article_type', '=', 'solutions-intelligence')->take(1)->first(); 
        });

        $meta_tag = DB::table('seo_meta_tags_pages')->where('page', '=', 'solutions-intelligence')->first();
        
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

        return view('website.solutions.intelligence.index', compact('latest_articles','featured_article'));
    }

    public function search($qry)
    {
        $articles = Article::where('status', 1)->where('article_type', '=', 'solutions-intelligence')->where('title', 'like', '%'.$qry.'%')->get();

        return response()->json($articles, 200);
    }

    public function list(Request $request)
    {
        $per_page = $request->input('per_page');
        $limit = $per_page;
        $no_of_records_per_page = $limit;
        $page = $request->input('page');
        $offset = ($page-1) * $no_of_records_per_page; 

        $articles = Article::where('status', 1)->where('article_type', '=', 'solutions-intelligence');

        if (!empty($request->input('qry'))) {
            $articles->where('title', 'like', '%'.$request->input('qry').'%');
        }

        $arr_categories = json_decode($request->input('categories'), true);
        if (!empty($arr_categories)) {
            $articles->whereHas('category_tag', function (Builder $query) use ($arr_categories) {
                $query->whereIn('sub_category_id', $arr_categories);
            });
        }
        
        $arr_types = json_decode($request->input('article_types'), true);
        if (!empty($arr_types)) {
            $articles->whereIn('type_id', $arr_types);
        }

        $total = $articles->count();

        if ($request->input('sort') == 1) {
            $articles->orderBy('title', 'asc');
        } elseif ($request->input('sort') == 2) {
            $articles->orderBy('title', 'desc');
        } elseif ($request->input('sort') == 3) {
            $articles->orderBy('created_at', 'desc');
        } else {
            $articles->orderBy('created_at', 'asc');
        }

        $res_articles = $articles->offset($offset)->limit($no_of_records_per_page)->get();

        $arr_articles = [];
        
        foreach ($res_articles as $article) {
            $thumb = check_file_exist('articles/thumbs/', 'thumb', $article->image_thumb);
            $arr_articles[] = [
                'id' => $article->id,
                'title' => $article->title,
                'url' => route('solutions.intelligence.details', [$article->slug]),
                'sub_title' => Str::limit($article->sub_title, 70).' <a href="'.route('solutions.intelligence.details', [$article->slug]).'" class="lightgreen-link">Learn More</a>',
                'thumb' => $thumb,
                'tags' => $article->category_tag,
            ];
        }

        $arr_results = [
            'total_rec' => $total,
            'results' => $arr_articles
        ];

        return response()->json($arr_results, 200);
    }

    public function details($slug)
    {
        $article = Article::where('status', 1)->where('slug', '=', $slug)->where('article_type', '=', 'solutions-intelligence')->firstOrFail();
        
        Meta::title($article->meta_title ? $article->meta_title : $article->title);
        Meta::set('robots', env('META_ROBOTS'));
        Meta::set('keywords', $article->meta_keywords);
        Meta::set('description', $article->meta_description ? $article->meta_description : Str::limit($article->sub_title, 120));
        Meta::set('author', 'Center for International Trade Expositions and Missions');
        Meta::set('image', $article->image_banner ? url('/storage/articles/banners/'.$article->image_banner) : asset('/assets/images/ssx-full-logo-white.png'));
        Meta::set('canonical', url()->current());

        $latest_articles = Article::where('status', 1)->where('article_type', '=', 'solutions-intelligence')->latest()->take(4)->get(); 
        
        return view('website.solutions.intelligence.details', compact('article','latest_articles'));
    }
}

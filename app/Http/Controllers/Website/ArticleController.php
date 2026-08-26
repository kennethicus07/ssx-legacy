<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Article;
use Meta;

class ArticleController extends Controller
{
    public function index()
    {
        $seconds = 86400; //1 Day
        
        $articles_carousel = cache()->remember('articles-'.Str::random(10), $seconds, function () {
            return Article::where('status', 1)->where('is_carousel', 1)->where('article_type', '=', 'news-articles')->latest()->get();
        });

        $latest_articles = cache()->remember('articles-'.Str::random(10), $seconds, function () {
            return Article::where('status', 1)->where('article_type', '=', 'news-articles')->latest()->take(3)->get(); 
        });

        $featured_article = cache()->remember('articles-'.Str::random(10), $seconds, function () {
            return Article::where('status', 1)->where('is_featured', 1)->where('article_type', '=', 'news-articles')->take(1)->first(); 
        });

        $meta_tag = DB::table('seo_meta_tags_pages')->where('page', '=', 'articles-news')->first();
        
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
        
        return view('website.article.index', compact('articles_carousel','latest_articles','featured_article'));
    }

    public function more_news_articles(Request $request)
    {
        $per_page = $request->input('per_page');
        $limit = $per_page;
        $no_of_records_per_page = $limit;
        $page = $request->input('page');
        $offset = ($page-1) * $no_of_records_per_page; 

        $articles = Article::where('status', 1)->where('article_type', '=', 'news-articles');

        $total = $articles->count();

        $res_articles = $articles->orderBy('created_at', 'desc')->offset($offset)->limit($no_of_records_per_page)->get();

        $arr_articles = [];
        
        foreach ($res_articles as $article) {
            $arr_articles[] = [
                'id' => $article->id,
                'title' => $article->title,
                'url' => route('news-articles.details', [$article->slug]),
                'sub_title' => Str::limit($article->sub_title, 70).' <a href="'.route('news-articles.details', [$article->slug]).'" class="lightgreen-link">Learn More</a>',
                'thumb' => $article->image_thumb,
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
        $article = Article::where('status', 1)->where('slug', '=', $slug)->where('article_type', '=', 'news-articles')->firstOrFail();
        
        Meta::title($article->meta_title ? $article->meta_title : $article->title);
        Meta::set('robots', env('META_ROBOTS'));
        Meta::set('keywords', $article->meta_keywords);
        Meta::set('description', $article->meta_description ? $article->meta_description : Str::limit($article->sub_title, 120));
        Meta::set('author', 'Center for International Trade Expositions and Missions');
        Meta::set('image', $article->image_banner ? url('/storage/articles/banners/'.$article->image_banner) : asset('/assets/images/ssx-full-logo-white.png'));
        Meta::set('canonical', url()->current());

        $latest_articles = Article::where('status', 1)->where('article_type', '=', 'news-articles')->latest()->take(4)->get(); 
        
        return view('website.article.details', compact('article','latest_articles'));
    }
}
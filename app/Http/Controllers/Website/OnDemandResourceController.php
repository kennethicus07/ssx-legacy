<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Article;
use Meta;

class OnDemandResourceController extends Controller
{
    public function on_demand_resources_list(Request $request)
    {
        $per_page = $request->input('per_page');
        $limit = $per_page;
        $no_of_records_per_page = $limit;
        $page = $request->input('page');
        $offset = ($page-1) * $no_of_records_per_page; 

        $articles = Article::where('status', 1)->where('article_type', '=', 'on-demand-resources');

        if ($request->input('sort') === 1) {
            $articles->orderBy('title', 'asc');
        } elseif ($request->input('sort') === 2) {
            $articles->orderBy('title', 'desc');
        } elseif ($request->input('sort') === 3) {
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
                'url' => route('on-demand-resources.details', [$article->slug]),
                'sub_title' => Str::limit($article->sub_title, 70).' <a href="'.route('on-demand-resources.details', [$article->slug]).'" class="lightgreen-link">Learn more</a>',
                'thumb' => $thumb,
                'tags' => $article->category_tag,
            ];
        }

        $arr_results = [
            'auth' => Auth::check(),
            'results' => $arr_articles
        ];
        
        return response()->json($arr_results, 200);
    }

    public function details($slug)
    {
        $article = Article::where('status', 1)->where('slug', '=', $slug)->where('article_type', '=', 'on-demand-resources')->firstOrFail();

        Meta::title($article->meta_title ? $article->meta_title : $article->title);
        Meta::set('robots', env('META_ROBOTS'));
        Meta::set('keywords', $article->meta_keywords);
        Meta::set('description', $article->meta_description ? $article->meta_description : Str::limit($article->sub_title, 120));
        Meta::set('author', 'Center for International Trade Expositions and Missions');
        Meta::set('image', $article->image_banner ? url('/storage/articles/banners/'.$article->image_banner) : asset('/assets/images/ssx-full-logo-white.png'));
        Meta::set('canonical', url()->current());

        $latest_articles = Article::where('status', 1)->where('article_type', '=', 'on-demand-resources')->latest()->take(4)->get(); 
        
        return view('website.ondemand.details', compact('article','latest_articles'));
    }
}

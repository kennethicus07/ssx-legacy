<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use App\Models\Enabler;
use App\Models\Article;
use Meta;

class ExportEnablerController extends Controller
{
    public function index()
    {
        $meta_tag = DB::table('seo_meta_tags_pages')->where('page', '=', 'export-enablers')->first();
        
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

        return view('website.enablers.index');
    }

    public function search($qry)
    {
        $companies = Enabler::where('status', 1)->where('co_name', 'like', '%'.$qry.'%')->get();
        return response()->json($companies, 200);
    }

    public function about()
    {
        $meta_tag = DB::table('seo_meta_tags_pages')->where('page', '=', 'export-enablers-about')->first();
        
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

        return view('website.enablers.about');
    }

    public function featured_partners()
    {
        $featured_partners = Enabler::where('status', 1)->where('is_featured', 1)->orderBy('co_name', 'asc')->get();
        foreach ($featured_partners as $partner) {
            $co_logo = check_file_exist('export_enablers/logo/', 'logo', $partner->co_logo);
            $thumb = check_file_exist('export_enablers/thumb/', 'thumb', $partner->thumb_image);
            $arr_results[] = [
                'id' => $partner->id,
                'name' => $partner->co_name,
                'details' => Str::limit($partner->co_details, 200),
                'logo' => $co_logo,
                'thumb' => $thumb,
                'website' => $partner->website,
                'email' => $partner->co_email,
                'facebook' => $partner->facebook,
                'twitter' => $partner->twitter,
                'instagram' => $partner->instagram,
                'wechat' => $partner->wechat,
                'tags' => $partner->category_tag,
            ];
        }
        return response()->json($arr_results, 200);
    }

    public function programs_offers()
    {
        $offers = Article::where('status', 1)->where('article_type', '=', 'programs-offers')->orderBy('created_at', 'desc')->limit(10)->get();
        foreach ($offers as $offer) {
            $co_logo = check_file_exist('articles/thumbs/', 'logo', $offer->image_thumb);
            $co_thumb = check_file_exist('articles/banners/', 'thumb', $offer->image_banner);

            $tags = [];
            if (!empty($offer->enabler->category_tag)) {
                $tags = $offer->enabler->category_tag;
            } 
            $arr_results[] = [
                'id' => $offer->id,
                'title' => $offer->title,
                'slug' => $offer->slug,
                'details' => Str::limit(strip_tags($offer->content), 70).' <a href="'.route('services.export-enablers.programs_offers_details', [$offer->id, $offer->slug]).'" class="lightgreen-link">Read more</a>',
                'thumb' => $co_thumb,
                'logo' => $co_logo,
                'enabler' => $offer->enabler,
                'tags' => $tags
            ];
        }
        return response()->json($arr_results, 200);
    }

    public function programs_offers_details($id, $slug)
    {
        $offer = Article::where('id', $id)->where('slug', '=', $slug)->firstOrFail();

        Meta::title($offer->meta_title ? $offer->meta_title : $offer->title.' - Featured Programs & Offers');
        Meta::set('robots', env('META_ROBOTS'));
        Meta::set('description', $offer->meta_description ? $offer->meta_description : Str::limit($offer->content, 120));
        Meta::set('author', 'Center for International Trade Expositions and Missions');
        Meta::set('image', $offer->image_banner ? url('/storage/articles/banners/'.$offer->image_banner) : asset('/assets/images/ssx-full-logo-white.png'));
        Meta::set('canonical', url()->current());

        $latest_articles = Article::where('status', 1)->where('article_type', '=', 'programs-offers')->latest()->take(4)->get(); 

        return view('website.enablers.details', compact('offer', 'latest_articles'));
    }

    public function list(Request $request)
    {
        $per_page = $request->input('per_page');
        $limit = $per_page;
        $no_of_records_per_page = $limit;
        $page = $request->input('page');
        $offset = ($page-1) * $no_of_records_per_page; 

        $enablers = Enabler::where('status', 1);

        if (!empty($request->input('qry'))) {
            $enablers->where('co_name', 'like', '%'.$request->input('qry').'%');
        }

        $arr_categories = json_decode($request->input('categories'), true);
        if (!empty($arr_categories)) {
            $enablers->whereHas('category_tag', function (Builder $query) use ($arr_categories) {
                $query->whereIn('sub_category_id', $arr_categories);
            });
        }

        $total = $enablers->count();

        if ($request->input('sort') == 1) {
            $enablers->orderBy('co_name', 'asc');
        } elseif ($request->input('sort') == 2) {
            $enablers->orderBy('co_name', 'desc');
        } elseif ($request->input('sort') == 3) {
            $enablers->orderBy('created_at', 'desc');
        } else {
            $enablers->orderBy('created_at', 'asc');
        }

        $res_enablers = $enablers->offset($offset)->limit($no_of_records_per_page)->get();

        $arr_enablers = [];
        
        foreach ($res_enablers as $enabler) {
            $co_logo = check_file_exist('export_enablers/logo/', 'logo', $enabler->co_logo);
            $co_thumb = check_file_exist('export_enablers/thumb/', 'thumb', $enabler->thumb_image);
            $arr_enablers[] = [
                'id' => $enabler->id,
                'name' => $enabler->co_name,
                'details' => $enabler->co_details,
                'logo' => $co_logo,
                'thumb' => $co_thumb,
                'website' => $enabler->website,
                'email' => $enabler->co_email,
                'facebook' => $enabler->facebook,
                'twitter' => $enabler->twitter,
                'instagram' => $enabler->instagram,
                'wechat' => $enabler->wechat,
                'tags' => $enabler->category_tag,
            ];
        }

        $arr_results = [
            'total_rec' => $total,
            'results' => $arr_enablers
        ];

        return response()->json($arr_results, 200);
    }
}

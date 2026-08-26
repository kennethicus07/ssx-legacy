<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Article;
use App\Models\Enabler;
use Carbon\Carbon;
use Image;
use Meta;

class ProgramOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.enablers.offers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $enablers = Enabler::where('status', 1)->orderBy('co_name', 'asc')->get();
        return view('admin.enablers.offers.create', compact('enablers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'enabler' => 'required',
            'content' => 'required'
        ]);

        $article = new Article;
        $article->title = $request->input('title');
        $article->slug = Str::slug($request->input('title'), '-');
        $article->enabler_id = $request->input('enabler');
        $article->article_type = 'programs-offers';
        $article->content = $request->input('content');
        $article->status = $request->input('status') ? 1 : 0;
        $article->meta_title = $request->input('meta_title');
        $article->meta_keywords = $request->input('meta_keywords');
        $article->meta_description = $request->input('meta_description');
        $article->added_by = Auth::id();

        $destinationPath = storage_path('app/public/articles');

        if ($request->hasFile('image_banner')) {
            $banner = $request->file('image_banner');
            if ($banner) {
                $filename_banner = md5(time()).'.'.$banner->clientExtension();
                $resize_banner = Image::make($banner);
                $resize_banner->save($destinationPath.'/banners/'.$filename_banner, 60);
                $article->image_banner = $filename_banner;
            }
        }

        if ($request->hasFile('image_thumb')) {
            $thumb = $request->file('image_thumb');
            if ($thumb) {
                $filename_thumb = md5(time()).'.'.$thumb->clientExtension();
                $resize_thumb = Image::make($thumb);
                $resize_thumb->fit(360, 200, function ($constraint_thumb) {
                    $constraint_thumb->upsize();
                });
                $resize_thumb->save($destinationPath.'/thumbs/'.$filename_thumb, 60);
                $article->image_thumb = $filename_thumb;
            }
        }

        $article->save();

        return redirect()->route('admin.export-enablers.programs-offers.index')->with('status', 'Article successfully saved.');
    }

    /**
     * Display the all resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $per_page = $request->input('per_page');
        $limit = $per_page;
        $no_of_records_per_page = $limit;
        $page = $request->input('page');
        $offset = ($page-1) * $no_of_records_per_page; 

        $articles = Article::where('article_type', '=', 'programs-offers');

        if ($request->has('filter')) {
            $filters = json_decode($request->input('filter'), true);
            if (!empty($filters['title'])) {
                $articles->where('title', 'like', '%'.$filters['title'].'%');
            }
            if (!empty($filters['status'])) {
                if ($filters['status'] == 'published') {
                    $status = 1;
                } else {
                    $status = 0;
                }
                $articles->where('status', $status);
            }
        }

        if ($request->has('sort')) {
            $sort = json_decode($request->input('sort'), true);
            $articles->orderBy("{$sort['field']}", "{$sort['type']}");
        }

        $total_articles = $articles->count();

        $records = $articles->offset($offset)->limit($no_of_records_per_page)->get();

        $arr_permissions = [
            'can_view' => Auth::user()->can('view offers'),
            'can_edit' => Auth::user()->can('edit offers'),
            'can_add' => Auth::user()->can('add offers'),
            'can_delete' => Auth::user()->can('delete offers')
        ];

        return response()->json(['total' => $total_articles, 'data' => $records, 'permissions' => $arr_permissions], 200);
    }

    public function show($id)
    {
        $offer = Article::findOrFail($id);

        Meta::title($offer->meta_title ? $offer->meta_title : $offer->title.' - Featured Programs & Offers');
        Meta::set('robots', 'noindex, nofollow');
        Meta::set('description', $offer->meta_description ? $offer->meta_description : Str::limit($offer->content, 120));
        Meta::set('author', 'Center for International Trade Expositions and Missions');
        Meta::set('image', $offer->image_banner ? url('/storage/articles/banners/'.$offer->image_banner) : asset('/assets/images/ssx-full-logo-white.png'));
        Meta::set('canonical', url()->current());

        $latest_articles = Article::where('status', 1)->where('article_type', '=', 'programs-offers')->latest()->take(4)->get(); 

        return view('website.enablers.details', compact('offer', 'latest_articles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $enablers = Enabler::where('status', 1)->orderBy('co_name', 'asc')->get();
        return view('admin.enablers.offers.update', compact('article','enablers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'enabler' => 'required',
            'content' => 'required'
        ]);

        $article->title = $request->input('title');
        $article->slug = Str::slug($request->input('title'), '-');
        $article->enabler_id = $request->input('enabler');
        $article->article_type = 'programs-offers';
        $article->content = $request->input('content');
        $article->status = $request->input('status') ? 1 : 0;
        $article->meta_title = $request->input('meta_title');
        $article->meta_keywords = $request->input('meta_keywords');
        $article->meta_description = $request->input('meta_description');
        $article->edited_by = Auth::id();

        $destinationPath = storage_path('app/public/articles');

        if ($request->hasFile('image_banner')) {
            $banner = $request->file('image_banner');
            if ($banner) {
                $filename_banner = md5(time()).'.'.$banner->clientExtension();
                $resize_banner = Image::make($banner);
                $resize_banner->save($destinationPath.'/banners/'.$filename_banner, 60);
                $article->image_banner = $filename_banner;
            }
        }

        if ($request->hasFile('image_thumb')) {
            $thumb = $request->file('image_thumb');
            if ($thumb) {
                $filename_thumb = md5(time()).'.'.$thumb->clientExtension();
                $resize_thumb = Image::make($thumb);
                $resize_thumb->fit(360, 200, function ($constraint_thumb) {
                    $constraint_thumb->upsize();
                });
                $resize_thumb->save($destinationPath.'/thumbs/'.$filename_thumb, 60);
                $article->image_thumb = $filename_thumb;
            }
        }

        $article->save();

        return redirect()->route('admin.export-enablers.programs-offers.index')->with('status', 'Article successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return response()->json(true, 200);
    }
}

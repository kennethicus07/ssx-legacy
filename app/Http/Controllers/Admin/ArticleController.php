<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Article;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ArticleType;
use Carbon\Carbon;
use Image;
use Meta;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.article.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $types = ArticleType::all();
        return view('admin.article.create', compact('categories','types'));
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
            'sub_title' => 'required',
            'content' => 'required',
            'type' => 'required|integer',
            'image_banner' => 'image',
            'image_thumb' => 'image'
        ]);

        $article = new Article;
        $article->title = $request->input('title');
        $article->slug = Str::slug($request->input('title'), '-');
        $article->sub_title = $request->input('sub_title');
        $article->type_id = $request->input('type');
        $article->article_type = 'news-articles';
        $article->author = $request->input('author');
        $article->content = $request->input('content');
        $article->status = $request->input('status') ? 1 : 0;
        $article->is_carousel = $request->input('carousel') ? 1 : 0;
        $article->meta_title = $request->input('meta_title');
        $article->meta_keywords = $request->input('meta_keywords');
        $article->meta_description = $request->input('meta_description');
        $article->added_by = Auth::id();

        if ($request->has('featured')) {
            if ($request->input('featured') == 1) {
                DB::table('articles')->update(['is_featured' => 0]);
                $article->is_featured = 1;
            } else {
                $article->is_featured = 0;
            }
        } else {
            $article->is_featured = 0;
        }
        
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

        if ($request->has('categories')) {
            $arr_categories = [];
            foreach ($request->input('categories') as $sub) {
                $sub_category = SubCategory::find($sub);
                if (!empty($sub_category)) {
                    $arr_categories[] = [
                        'category_id' => $sub_category->category_id,
                        'sub_category_id' => $sub_category->id,
                        'category_remarks' => $sub_category->category->name,
                        'sub_category_remarks' => $sub_category->name
                    ];
                }
            }
            $article->category_tag()->createMany($arr_categories);
        }

        return redirect()->route('admin.news-articles.index')->with('status', 'Article successfully saved.');
    }

    public function show($id) 
    {
        $article = Article::findOrFail($id);
        
        Meta::title($article->meta_title ? $article->meta_title : $article->title);
        Meta::set('robots', 'noindex,nofollow');
        Meta::set('keywords', $article->meta_keywords);
        Meta::set('description', $article->meta_description ? $article->meta_description : Str::limit($article->sub_title, 120));
        Meta::set('author', 'Center for International Trade Expositions and Missions');
        Meta::set('image', $article->image_banner ? url('/storage/articles/banners/'.$article->image_banner) : asset('/assets/images/ssx-full-logo-white.png'));
        Meta::set('canonical', url()->current());

        $latest_articles = Article::where('status', 1)->where('article_type', '=', 'news-articles')->latest()->take(4)->get(); 
        
        return view('website.article.details', compact('article','latest_articles'));
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

        $articles = Article::where('article_type', '=', 'news-articles');

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
            if (!empty($filters['featured'])) {
                if ($filters['featured'] === 'yes') {
                    $featured = 1;
                } else {
                    $featured = 0;
                }
                $articles->where('is_featured', $featured);
            }
            if (!empty($filters['carousel'])) {
                if ($filters['carousel'] === 'yes') {
                    $carousel = 1;
                } else {
                    $carousel = 0;
                }
                $articles->where('is_carousel', $carousel);
            }
        }

        if ($request->has('sort')) {
            $sort = json_decode($request->input('sort'), true);
            $articles->orderBy("{$sort['field']}", "{$sort['type']}");
        }

        $total_articles = $articles->count();

        $records = $articles->offset($offset)->limit($no_of_records_per_page)->get();

        $arr_permissions = [
            'can_view' => Auth::user()->can('view articles'),
            'can_edit' => Auth::user()->can('edit articles'),
            'can_add' => Auth::user()->can('add articles'),
            'can_delete' => Auth::user()->can('delete articles')
        ];

        return response()->json(['total' => $total_articles, 'data' => $records, 'permissions' => $arr_permissions], 200);
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
        $categories = Category::all();
        $types = ArticleType::all();
        $arr_tags = [];
        if (!empty($article->category_tag)) {
            foreach ($article->category_tag as $tag) {
                $arr_tags[] = $tag->sub_category_id;
            }
        }
        return view('admin.article.update', compact('article','categories','types','arr_tags'));
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
            'sub_title' => 'required',
            'content' => 'required',
            'type' => 'required',
            'image_banner' => 'image',
            'image_thumb' => 'image'
        ]);

        $article->title = $request->input('title');
        $article->slug = Str::slug($request->input('title'), '-');
        $article->sub_title = $request->input('sub_title');
        $article->type_id = $request->input('type');
        $article->article_type = 'news-articles';
        $article->author = $request->input('author');
        $article->content = $request->input('content');
        $article->status = $request->input('status') ? 1 : 0;
        $article->is_carousel = $request->input('carousel') ? 1 : 0;
        $article->meta_title = $request->input('meta_title');
        $article->meta_keywords = $request->input('meta_keywords');
        $article->meta_description = $request->input('meta_description');
        $article->edited_by = Auth::id();

        if ($request->has('featured')) {
            if ($request->input('featured') == 1) {
                DB::table('articles')->update(['is_featured' => 0]);
                $article->is_featured = 1;
            } else {
                $article->is_featured = 0;
            }
        } else {
            $article->is_featured = 0;
        }

        $destinationPath = storage_path('app/public/articles');
        if ($request->hasFile('image_banner')) {
            $banner = $request->file('image_banner');
            if ($banner) {
                $filename_banner = md5(time()).'.'.$banner->clientExtension();
                $resize_banner = Image::make($banner);
                $resize_banner->save($destinationPath.'/banners/'.$filename_banner, 70);
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
                $resize_thumb->save($destinationPath.'/thumbs/'.$filename_thumb, 70);
                $article->image_thumb = $filename_thumb;
            }
        }
        
        if ($request->has('categories')) {
            if (!empty($article->category_tag)) {
                $article->category_tag()->delete();
            }
            $arr_categories = [];
            foreach ($request->input('categories') as $sub) {
                $sub_category = SubCategory::find($sub);
                if (!empty($sub_category)) {
                    $arr_categories[] = [
                        'category_id' => $sub_category->category_id,
                        'sub_category_id' => $sub_category->id,
                        'category_remarks' => $sub_category->category->name,
                        'sub_category_remarks' => $sub_category->name
                    ];
                }
            }
            $article->category_tag()->createMany($arr_categories);
        }

        $article->save();

        return redirect()->route('admin.news-articles.index')->with('status', 'Article successfully updated.');
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

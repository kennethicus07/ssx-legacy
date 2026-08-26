<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use App\Models\Carousel;
use Carbon\Carbon;
use Image;

class CarouselController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.carousel.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.carousel.create');
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
        ]);

        $banner = new Carousel;
        $banner->title = $request->input('title');
        $banner->details = $request->input('details');
        $banner->status = $request->input('status') ? $request->input('status') : 0;
        $banner->url = $request->input('url');
        $banner->added_by = Auth::id();

        $destinationPath = storage_path('app/public/carousel_banners/');
        if ($request->hasFile('image_banner')) {
            $banner_image = $request->file('image_banner');
            if ($banner_image) {
                $filename_banner = md5(time()).'.'.$banner_image->clientExtension();
                $resize_banner = Image::make($banner_image);
                $resize_banner->fit(1440, 536);
                $resize_banner->save($destinationPath.$filename_banner, 70);
                $banner->banner = $filename_banner;
            }
        }

        $banner->save();

        Cache::forget('home-carousel-banners');

        return redirect()->route('admin.carousel-banners.index')->with('status', 'Banner successfully saved.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $per_page = $request->input('per_page');
        $limit = $per_page;
        $no_of_records_per_page = $limit;
        $page = $request->input('page');
        $offset = ($page-1) * $no_of_records_per_page; 

        $banners = Carousel::whereNotNull('title');

        if ($request->has('filter')) {
            $filters = json_decode($request->input('filter'), true);
            if (!empty($filters['title'])) {
                $banners->where('title', 'like', '%'.$filters['title'].'%');
            }
            if (!empty($filters['status'])) {
                if ($filters['status'] == 'published') {
                    $banners->where('status', 1);
                } else {
                    $banners->where('status', 0);
                }
            }
        }

        if ($request->has('sort')) {
            $sort = json_decode($request->input('sort'), true);
            $banners->orderBy("{$sort['field']}", "{$sort['type']}");
        }

        $total_banners = $banners->count();

        $records = $banners->offset($offset)->limit($no_of_records_per_page)->get();

        $arr_permissions = [
            'can_add' => Auth::user()->can('add carousel'),
            'can_edit' => Auth::user()->can('edit carousel'),
            'can_delete' => Auth::user()->can('delete carousel')
        ];

        return response()->json(['total' => $total_banners, 'data' => $records, 'permissions' => $arr_permissions], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = Carousel::findOrFail($id);
        return view('admin.carousel.update', ['banner' => $banner]);
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
        $request->validate([
            'title' => 'required',
            'image_banner' => 'image'
        ]);

        $banner = Carousel::findOrFail($id);

        $banner->title = $request->input('title');
        $banner->details = $request->input('details');
        $banner->status = $request->input('status') ? $request->input('status') : 0;
        $banner->url = $request->input('url');
        $banner->edited_by = Auth::id();

        $destinationPath = storage_path('app/public/carousel_banners/');
        if ($request->hasFile('image_banner')) {
            $banner_image = $request->file('image_banner');
            if ($banner_image) {
                $filename_banner = md5(time()).'.'.$banner_image->clientExtension();
                $resize_banner = Image::make($banner_image);
                $resize_banner->fit(1440, 536);
                $resize_banner->save($destinationPath.$filename_banner, 70);
                $banner->banner = $filename_banner;
            }
        }

        $banner->save();

        Cache::forget('home-carousel-banners');

        return redirect()->route('admin.carousel-banners.index')->with('status', 'Banner successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Carousel::findOrFail($id);
        $banner->delete();
        Cache::forget('home-carousel-banners');
        return response()->json(true, 200);
    }
}

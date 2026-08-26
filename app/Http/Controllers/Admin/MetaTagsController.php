<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\MetaTag;
use Carbon\Carbon;
use Image;

class MetaTagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.meta.index');
    }

    /**
     * List a created resource in storage.
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

        $tags = MetaTag::whereNotNull('title');

        if ($request->has('filter')) {
            $filters = json_decode($request->input('filter'), true);
            if (!empty($filters['title'])) {
                $tags->where('title', 'like', '%'.$filters['title'].'%');
            }
        }

        if ($request->has('sort')) {
            $sort = json_decode($request->input('sort'), true);
            $tags->orderBy("{$sort['field']}", "{$sort['type']}");
        }

        $total_tags = $tags->count();

        $records = $tags->offset($offset)->limit($no_of_records_per_page)->get();

        $arr_permissions = [
            'can_view' => Auth::user()->can('view seo'),
            'can_edit' => Auth::user()->can('edit seo'),
            'can_add' => Auth::user()->can('add seo'),
            'can_delete' => Auth::user()->can('delete seo')
        ];

        return response()->json(['total' => $total_tags, 'data' => $records, 'permissions' => $arr_permissions], 200);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = MetaTag::findOrFail($id);

        $arr_robots = [];
        if (!empty($tag->meta_robots)) {
            $arr_robots = explode(',', $tag->meta_robots);
        }
        return view('admin.meta.update', ['tag' => $tag, 'arr_robots' => $arr_robots]);
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
        $tag = MetaTag::findOrFail($id);

        $request->validate([
            'title' => 'required'
        ]);

        $arr_robots = [];
        if (!empty($request->input('meta_robots'))) {
            $arr_robots = $request->input('meta_robots');
        }
        $meta_robots = implode(',', $arr_robots);

        $tag->title = $request->input('title');
        $tag->meta_title = $request->input('meta_title');
        $tag->meta_keywords = $request->input('meta_keywords');
        $tag->meta_description = $request->input('meta_description');
        $tag->meta_robots = $meta_robots;
        $tag->meta_author = $request->input('meta_author');
        $tag->edited_by = Auth::id();

        $destinationPath = storage_path('app/public/meta_images/');
        if ($request->hasFile('meta_image')) {
            $meta_image = $request->file('meta_image');
            if ($meta_image) {
                $filename = md5(time()).'.'.$meta_image->clientExtension();
                $canvas = Image::canvas(1200, 627);
                $resize_image = Image::make($meta_image);
                $resize_image->resize(1200, 627, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $canvas->insert($resize_image, 'center');
                $canvas->save($destinationPath.$filename, 70);
                $tag->meta_image = $filename;
            }
        }

        $tag->save();
        
        return redirect()->route('admin.pages-meta-tags.index')->with('status', 'Meta tag successfully updated.');
    }

}

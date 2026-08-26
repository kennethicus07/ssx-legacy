<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\EnablerCategories;
use App\Models\EnablerSubCategories;
use App\Models\Enabler;
use Carbon\Carbon;
use Image;
use Meta;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.enablers.companies.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = EnablerCategories::all();

        return view('admin.enablers.companies.create', compact('categories'));
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
            'name' => 'required',
            'details' => 'required'
        ]);

        $enabler = new Enabler;
        $enabler->co_name = $request->input('name');
        $enabler->co_details = $request->input('details');
        $enabler->co_email = $request->input('email');
        $enabler->website = $request->input('website');
        $enabler->facebook = $request->input('facebook');
        $enabler->instagram = $request->input('instagram');
        $enabler->twitter = $request->input('twitter');
        $enabler->wechat = $request->input('wechat');
        $enabler->status = $request->input('status') ? 1 : 0;
        $enabler->is_featured = $request->input('featured') ? 1 : 0;
        $enabler->added_by = Auth::id();

        $destinationPath = storage_path('app/public/export_enablers/');
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            if ($logo) {
                $filename_logo = md5(time()).'.'.$logo->clientExtension();
                $logo_canvas = Image::canvas(156, 156);
                $resize_logo = Image::make($logo);
                $resize_logo->resize(150, 150, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $logo_canvas->insert($resize_logo, 'center');
                $logo_canvas->save($destinationPath.'/logo/'.$filename_logo, 70);
                $enabler->co_logo = $filename_logo;
            }
        }
        if ($request->hasFile('thumb')) {
            $thumb = $request->file('thumb');
            if ($thumb) {
                $filename_thumb = md5(time()).'.'.$thumb->clientExtension();
                $resize_thumb = Image::make($thumb);
                $resize_thumb->fit(360, 200, function ($constraint_thumb) {
                    $constraint_thumb->upsize();
                });
                $resize_thumb->save($destinationPath.'/thumb/'.$filename_thumb, 70);
                $enabler->thumb_image = $filename_thumb;
            }
        }   

        $enabler->save();

        if ($request->has('categories')) {
            $arr_categories = [];
            foreach ($request->input('categories') as $sub) {
                $sub_category = EnablerSubCategories::find($sub);
                if (!empty($sub_category)) {
                    $arr_categories[] = [
                        'category_id' => $sub_category->category_id,
                        'sub_category_id' => $sub_category->id,
                        'category_remarks' => $sub_category->category->name,
                        'sub_category_remarks' => $sub_category->name
                    ];
                }
            }
            $enabler->category_tag()->createMany($arr_categories);
        }

        return redirect()->route('admin.export-enablers.companies.index')->with('status', 'Enabler successfully saved.');
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

        $enablers = Enabler::whereNotNull('co_name');

        if ($request->has('filter')) {
            $filters = json_decode($request->input('filter'), true);
            if (!empty($filters['title'])) {
                $enablers->where('co_name', 'like', '%'.$filters['title'].'%');
            }
            if (!empty($filters['email'])) {
                $enablers->where('co_email', 'like', '%'.$filters['email'].'%');
            }
            if (!empty($filters['status'])) {
                if ($filters['status'] == 'published') {
                    $enablers->where('status', 1);
                } else {
                    $enablers->where('status', 0);
                }
            }
        }

        if ($request->has('sort')) {
            $sort = json_decode($request->input('sort'), true);
            $enablers->orderBy("{$sort['field']}", "{$sort['type']}");
        }

        $total_enablers = $enablers->count();

        $records = $enablers->offset($offset)->limit($no_of_records_per_page)->get();

        $arr_permissions = [
            'can_view' => Auth::user()->can('view enablers'),
            'can_edit' => Auth::user()->can('edit enablers'),
            'can_add' => Auth::user()->can('add enablers'),
            'can_delete' => Auth::user()->can('delete enablers')
        ];

        return response()->json(['total' => $total_enablers, 'data' => $records, 'permissions' => $arr_permissions], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $enabler = Enabler::findOrFail($id);
        $categories = EnablerCategories::all();
        $arr_tags = [];
        if (!empty($enabler->category_tag)) {
            foreach ($enabler->category_tag as $tag) {
                $arr_tags[] = $tag->sub_category_id;
            }
        }

        return view('admin.enablers.companies.update', compact('enabler','categories','arr_tags'));
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
        $enabler = Enabler::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'details' => 'required'
        ]);

        $enabler->co_name = $request->input('name');
        $enabler->co_details = $request->input('details');
        $enabler->co_email = $request->input('email');
        $enabler->website = $request->input('website');
        $enabler->facebook = $request->input('facebook');
        $enabler->instagram = $request->input('instagram');
        $enabler->twitter = $request->input('twitter');
        $enabler->wechat = $request->input('wechat');
        $enabler->status = $request->input('status') ? 1 : 0;
        $enabler->is_featured = $request->input('featured') ? 1 : 0;
        $enabler->edited_by = Auth::id();

        $destinationPath = storage_path('app/public/export_enablers/');
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            if ($logo) {
                $filename_logo = md5(time()).'.'.$logo->clientExtension();
                $logo_canvas = Image::canvas(220, 220);
                $resize_logo = Image::make($logo);
                $resize_logo->resize(200, 200, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $logo_canvas->insert($resize_logo, 'center');
                $logo_canvas->save($destinationPath.'/logo/'.$filename_logo, 70);
                $enabler->co_logo = $filename_logo;
            }
        }
        if ($request->hasFile('thumb')) {
            $thumb = $request->file('thumb');
            if ($thumb) {
                $filename_thumb = md5(time()).'.'.$thumb->clientExtension();
                $resize_thumb = Image::make($thumb);
                $resize_thumb->fit(360, 200, function ($constraint_thumb) {
                    $constraint_thumb->upsize();
                });
                $resize_thumb->save($destinationPath.'/thumb/'.$filename_thumb, 70);
                $enabler->thumb_image = $filename_thumb;
            }
        }   

        $enabler->save();

        if ($request->has('categories')) {
            if (!empty($enabler->category_tag)) {
                $enabler->category_tag()->delete();
            }
            $arr_categories = [];
            foreach ($request->input('categories') as $sub) {
                $sub_category = EnablerSubCategories::find($sub);
                if (!empty($sub_category)) {
                    $arr_categories[] = [
                        'category_id' => $sub_category->category_id,
                        'sub_category_id' => $sub_category->id,
                        'category_remarks' => $sub_category->category->name,
                        'sub_category_remarks' => $sub_category->name
                    ];
                }
            }
            $enabler->category_tag()->createMany($arr_categories);
        }

        return redirect()->route('admin.export-enablers.companies.index')->with('status', 'Enabler successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $enabler = Enabler::findOrFail($id);
        $enabler->delete();

        return response()->json(true, 200);
    }
}

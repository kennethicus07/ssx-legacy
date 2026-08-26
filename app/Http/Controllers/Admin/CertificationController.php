<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Certification;
use Carbon\Carbon;
use Image;

class CertificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.certifications.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.certifications.create');
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
        ]);

        $certification = new Certification;
        $certification->name = $request->input('name');
        $certification->details = $request->input('details');
        $certification->status = $request->input('status') ? $request->input('status') : 0;
        $certification->added_by = Auth::id();

        $destinationPath = storage_path('app/public/certifications/');
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            if ($logo) {
                $filename_logo = md5(time()).'.'.$logo->clientExtension();
                $logo_canvas = Image::canvas(310, 310);
                $resize_logo = Image::make($logo);
                $resize_logo->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $logo_canvas->insert($resize_logo, 'center');
                $logo_canvas->save($destinationPath.$filename_logo, 70);
                $certification->logo = $filename_logo;
            }
        }

        $certification->save();

        return redirect()->route('admin.certifications.index')->with('status', 'Certification successfully saved.');
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

        $cetifications = Certification::whereNotNull('name');

        if ($request->has('filter')) {
            $filters = json_decode($request->input('filter'), true);
            if (!empty($filters['title'])) {
                $cetifications->where('name', 'like', '%'.$filters['title'].'%');
            }
            if (!empty($filters['status'])) {
                if ($filters['status'] == 'published') {
                    $cetifications->where('status', 1);
                } else {
                    $cetifications->where('status', 0);
                }
            }
        }

        if ($request->has('sort')) {
            $sort = json_decode($request->input('sort'), true);
            $cetifications->orderBy("{$sort['field']}", "{$sort['type']}");
        }

        $total_cetifications = $cetifications->count();

        $records = $cetifications->offset($offset)->limit($no_of_records_per_page)->get();

        $arr_permissions = [
            'can_view' => Auth::user()->can('view certifications'),
            'can_edit' => Auth::user()->can('edit certifications'),
            'can_add' => Auth::user()->can('add certifications'),
            'can_delete' => Auth::user()->can('delete certifications')
        ];

        return response()->json(['total' => $total_cetifications, 'data' => $records, 'permissions' => $arr_permissions], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $certification = Certification::findOrFail($id);
        return view('admin.certifications.update', ['certification' => $certification]);
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
            'name' => 'required',
        ]);

        $certification = Certification::findOrFail($id);

        $certification->name = $request->input('name');
        $certification->details = $request->input('details');
        $certification->status = $request->input('status') ? $request->input('status') : 0;
        $certification->edited_by = Auth::id();

        $destinationPath = storage_path('app/public/certifications/');
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            if ($logo) {
                $filename_logo = md5(time()).'.'.$logo->clientExtension();
                $logo_canvas = Image::canvas(310, 310);
                $resize_logo = Image::make($logo);
                $resize_logo->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $logo_canvas->insert($resize_logo, 'center');
                $logo_canvas->save($destinationPath.$filename_logo, 70);
                $certification->logo = $filename_logo;
            }
        }

        $certification->save();

        return redirect()->route('admin.certifications.index')->with('status', 'Certification successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $certification = Certification::findOrFail($id);
        $certification->delete();
        return response()->json(true, 200);
    }
}

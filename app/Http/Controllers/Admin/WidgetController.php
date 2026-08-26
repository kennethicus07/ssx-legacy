<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Models\Widget;

class WidgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.widget.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.widget.create');
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
            'details' => 'required'
        ]);

        $widget = new Widget;
        $widget->title = $request->input('title');
        $widget->details = $request->input('details');
        $widget->status = $request->input('status') ? $request->input('status') : 0;
        $widget->added_by = Auth::id();

        $widget->save();

        Cache::forget('widget_'.$widget->id);

        return redirect()->route('admin.widgets.index')->with('status', 'Widget successfully saved.');
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

        $widgets = Widget::whereNotNull('title');

        if ($request->has('filter')) {
            $filters = json_decode($request->input('filter'), true);
            if (!empty($filters['title'])) {
                $widgets->where('title', 'like', '%'.$filters['title'].'%');
            }
            if (!empty($filters['status'])) {
                if ($filters['status'] == 'published') {
                    $widgets->where('status', 1);
                } else {
                    $widgets->where('status', 0);
                }    
            }
        }

        if ($request->has('sort')) {
            $sort = json_decode($request->input('sort'), true);
            $widgets->orderBy("{$sort['field']}", "{$sort['type']}");
        }

        $total_widgets = $widgets->count();

        $records = $widgets->offset($offset)->limit($no_of_records_per_page)->get();

        $arr_permissions = [
            'can_view' => Auth::user()->can('view widgets'),
            'can_edit' => Auth::user()->can('edit widgets'),
            'can_add' => Auth::user()->can('add widgets'),
            'can_delete' => Auth::user()->can('delete widgets')
        ];

        return response()->json(['total' => $total_widgets, 'data' => $records, 'permissions' => $arr_permissions], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $widget = Widget::findOrFail($id);
        return view('admin.widget.update', ['widget' => $widget]);
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
            'details' => 'required'
        ]);

        $widget = Widget::findOrFail($id);

        $widget->title = $request->input('title');
        $widget->details = $request->input('details');
        $widget->status = $request->input('status') ? $request->input('status') : 0;
        $widget->edited_by = Auth::id();

        $widget->save();

        Cache::forget('widget_'.$widget->id);

        return redirect()->route('admin.widgets.index')->with('status', 'Widget successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $widget = Widget::findOrFail($id);
        Cache::forget('widget_'.$widget->id);
        $widget->delete();
        
        return response()->json(true, 200);
    }
}

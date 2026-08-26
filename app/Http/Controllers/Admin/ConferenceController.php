<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Conference;
use Carbon\Carbon;

class ConferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.exhibitions_conferences.conference.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.exhibitions_conferences.conference.create');
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
            'con_date' => 'required'
        ]);

        $conference = new Conference;
        $conference->title = $request->input('title');
        $conference->sub_title = $request->input('sub_title');
        $conference->status = $request->input('status') ? $request->input('status') : 0;
        $conference->conference_date = Carbon::createFromFormat('d/m/Y', $request->input('con_date'))->format('Y-m-d');
        $conference->added_by = Auth::id();
        
        $conference->save();
        
        return redirect()->route('admin.exhibitions-conferences.index')->with('status', 'Exhibition & conferences successfully saved.');
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

        $conferences = Conference::whereNotNull('title');

        if ($request->has('filter')) {
            $filters = json_decode($request->input('filter'), true);
            if (!empty($filters['title'])) {
                $conferences->where('title', 'like', '%'.$filters['title'].'%');
            }
        }

        if ($request->has('sort')) {
            $sort = json_decode($request->input('sort'), true);
            $conferences->orderBy("{$sort['field']}", "{$sort['type']}");
        }

        $total_conferences = $conferences->count();

        $records = $conferences->offset($offset)->limit($no_of_records_per_page)->get();

        $arr_permissions = [
            'can_view' => Auth::user()->can('view conference'),
            'can_edit' => Auth::user()->can('edit conference'),
            'can_add' => Auth::user()->can('add conference'),
            'can_delete' => Auth::user()->can('delete conference')
        ];

        return response()->json(['total' => $total_conferences, 'data' => $records, 'permissions' => $arr_permissions], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $conference = Conference::findOrFail($id);

        return view('admin.exhibitions_conferences.conference.update', compact('conference'));
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
        $conference = Conference::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'sub_title' => 'required',
            'con_date' => 'required'
        ]);

        $conference->title = $request->input('title');
        $conference->sub_title = $request->input('sub_title');
        $conference->status = $request->input('status') ? $request->input('status') : 0;
        $conference->conference_date = Carbon::createFromFormat('d/m/Y', $request->input('con_date'))->format('Y-m-d');
        $conference->edited_by = Auth::id();
        $conference->save();
        
        return redirect()->route('admin.exhibitions-conferences.index')->with('status', 'Exhibition & conferences successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conference = Conference::findOrFail($id);
        $conference->delete();
        return response()->json(true, 200);
    }
}

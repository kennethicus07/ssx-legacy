<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Page;
use Meta;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.create');
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
            'title' => 'required|unique:App\Models\Page,title',
            'details' => 'required'
        ]);

        $page = new Page;
        $page->title = $request->input('title');
        $page->slug = Str::slug($request->input('title'), '-');
        $page->description = $request->input('details');
        $page->status = $request->input('status') ? $request->input('status') : 0;
        $page->meta_title = $request->input('meta_title');
        $page->meta_keywords = $request->input('meta_keywords');
        $page->meta_description = $request->input('meta_description');
        $page->added_by = Auth::id();

        $page->save();

        return redirect()->route('admin.pages.index')->with('status', 'Page successfully saved.');
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

        $pages = Page::whereNotNull('title');

        if ($request->has('filter')) {
            $filters = json_decode($request->input('filter'), true);
            if (!empty($filters['title'])) {
                $pages->where('title', 'like', '%'.$filters['title'].'%');
            }
            if (!empty($filters['status'])) {
                if ($filters['status'] == 'published') {
                    $pages->where('status', 1);
                } else {
                    $pages->where('status', 0);
                }    
            }
        }

        if ($request->has('sort')) {
            $sort = json_decode($request->input('sort'), true);
            $pages->orderBy("{$sort['field']}", "{$sort['type']}");
        }

        $total_pages = $pages->count();

        $records = $pages->offset($offset)->limit($no_of_records_per_page)->get();

        $arr_permissions = [
            'can_view' => Auth::user()->can('view pages'),
            'can_edit' => Auth::user()->can('edit pages'),
            'can_add' => Auth::user()->can('add pages'),
            'can_delete' => Auth::user()->can('delete pages')
        ];

        return response()->json(['total' => $total_pages, 'data' => $records, 'permissions' => $arr_permissions], 200);
    }

    public function show($id)
    {
        $page = Page::findOrFail($id);

        Meta::title($page->meta_title);
        Meta::set('robots', 'noindex,nofollow');
        Meta::set('keywords', $page->meta_keywords);
        Meta::set('description', $page->meta_description);
        Meta::set('author', 'CITEM');
        Meta::set('canonical', url()->current());

        return view('website.home.page', compact('page'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.update', ['page' => $page]);
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
        $page = Page::findOrFail($id);

        $request->validate([
            'title' => 'required|unique:App\Models\Page,title,'.$page->id,
            'details' => 'required'
        ]);

        $page->title = $request->input('title');
        $page->slug = Str::slug($request->input('title'), '-');
        $page->description = $request->input('details');
        $page->status = $request->input('status') ? $request->input('status') : 0;
        $page->meta_title = $request->input('meta_title');
        $page->meta_keywords = $request->input('meta_keywords');
        $page->meta_description = $request->input('meta_description');
        $page->edited_by = Auth::id();

        $page->save();

        return redirect()->route('admin.pages.index')->with('status', 'Page successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();
        
        return response()->json(true, 200);
    }
}

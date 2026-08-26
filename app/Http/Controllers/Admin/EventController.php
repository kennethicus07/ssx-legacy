<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Event;
use App\Models\Category;
use App\Models\SubCategory;
use Carbon\Carbon;
use Image;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.event.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.event.create', ['categories' => $categories]);
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
            'event_happening' => 'required',
            'event_type' => 'required',
            'platform' => 'required_if:event_type,digital',
            'location' => 'required_if:event_type,on-site',
            'event_date_from' => 'required',
            'organizer' => 'required',
            'event_link' => 'required',
            'details' => 'required'
        ]);

        $event = new Event;
        $event->title = $request->input('title');
        $event->event_happening = $request->input('event_happening');
        $event->event_type = $request->input('event_type');
        $event->platform = $request->input('platform');
        $event->location = $request->input('location');
        $event->event_date_1 = Carbon::createFromFormat('d/m/Y', $request->input('event_date_from'))->format('Y-m-d');
        $event->event_date_2 = $request->input('event_date_to') ? Carbon::createFromFormat('d/m/Y', $request->input('event_date_to'))->format('Y-m-d') : NULL;
        $event->organizer = $request->input('organizer');
        $event->event_link = $request->input('event_link');
        $event->description = $request->input('details');
        $event->status = $request->input('status') ? $request->input('status') : 0;
        $event->is_educate = $request->input('is_educate') ? $request->input('is_educate') : 0;
        $event->meta_title = $request->input('meta_title');
        $event->meta_description = $request->input('meta_description');
        $event->added_by = Auth::id();

        if ($request->input('is_featured')) {
            DB::table('events')->update(['is_featured' => 0]);
            $event->is_featured = 1;
        } else {
            $event->is_featured = 0;
        }

        if ($request->input('is_educate')) {
            DB::table('events')->update(['is_educate' => 0]);
            $event->is_educate = 1;
        } else {
            $event->is_educate = 0;
        }

        if ($request->input('is_aboutus')) {
            DB::table('events')->update(['is_aboutus' => 0]);
            $event->is_aboutus = 1;
        } else {
            $event->is_aboutus = 0;
        }

        $destinationPath = storage_path('app/public/events');

        if ($request->hasFile('organizer_logo')) {
            $org_logo = $request->file('organizer_logo');
            if ($org_logo) {
                $filename_org_logo = md5(time()).'.'.$org_logo->clientExtension();
                $org_logo_canvas = Image::canvas(220, 220);
                $resize_org_logo = Image::make($org_logo);
                $resize_org_logo->resize(200, 200, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $org_logo_canvas->insert($resize_org_logo, 'center');
                $org_logo_canvas->save($destinationPath.'/organizer_logos/'.$filename_org_logo, 70);
                $event->organizer_logo = $filename_org_logo;
            }
        }

        if ($request->hasFile('event_banner')) {
            $banner = $request->file('event_banner');
            if ($banner) {
                $filename_banner = md5(time()).'.'.$banner->clientExtension();
                $resize_banner = Image::make($banner);
                $resize_banner->fit(360, 200, function ($constraint_banner1) {
                    $constraint_banner1->upsize();
                });
                $resize_banner->save($destinationPath.'/thumbs/'.$filename_banner, 70);
                $resize_banner->fit(650, 650, function ($constraint_banner) {
                    $constraint_banner->upsize();
                });
                $resize_banner->save($destinationPath.'/banners/'.$filename_banner, 70);
                $event->event_banner = $filename_banner;
            }
        }   
        $event->save();

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
            $event->category_tag()->createMany($arr_categories);
        }

        return redirect()->route('admin.events-activities.index')->with('status', 'Event successfully saved.');
    }

    public function list(Request $request)
    {
        $per_page = $request->input('per_page');
        $limit = $per_page;
        $no_of_records_per_page = $limit;
        $page = $request->input('page');
        $offset = ($page-1) * $no_of_records_per_page; 

        $event = Event::whereNotNull('title');

        if ($request->has('filter')) {
            $filters = json_decode($request->input('filter'), true);
            if (!empty($filters['title'])) {
                $event->where('title', 'like', '%'.$filters['title'].'%');
            }
            if (!empty($filters['status'])) {
                if ($filters['status'] == 'published') {
                    $status = 1;
                } else {
                    $status = 0;
                }
                $event->where('status', $status);
            }
            if (!empty($filters['happening'])) {
                $event->where('event_happening', $filters['event_happening']);
            }
            if (!empty($filters['type'])) {
                $event->where('is_carousel', $filters['type']);
            }
        }

        if ($request->has('sort')) {
            $sort = json_decode($request->input('sort'), true);
            $event->orderBy("{$sort['field']}", "{$sort['type']}");
        }

        $total_events = $event->count();

        $records = $event->offset($offset)->limit($no_of_records_per_page)->get();

        $arr_permissions = [
            'can_view' => Auth::user()->can('view enablers'),
            'can_edit' => Auth::user()->can('edit enablers'),
            'can_add' => Auth::user()->can('add enablers'),
            'can_delete' => Auth::user()->can('delete enablers')
        ];

        return response()->json(['total' => $total_events, 'data' => $records, 'permissions' => $arr_permissions], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $categories = Category::all();
        $arr_tags = [];
        if (!empty($event->category_tag)) {
            foreach ($event->category_tag as $tag) {
                $arr_tags[] = $tag->sub_category_id;
            }
        }
        return view('admin.event.update', ['categories' => $categories, 'event' => $event, 'arr_tags' => $arr_tags]);
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
        $event = Event::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'event_happening' => 'required',
            'event_type' => 'required',
            'platform' => 'required_if:event_type,digital',
            'location' => 'required_if:event_type,on-site',
            'event_date_from' => 'required',
            'organizer' => 'required',
            'event_link' => 'required',
            'details' => 'required'
        ]);

        $event->title = $request->input('title');
        $event->event_happening = $request->input('event_happening');
        $event->event_type = $request->input('event_type');
        $event->platform = $request->input('platform');
        $event->location = $request->input('location');
        $event->event_date_1 = Carbon::createFromFormat('d/m/Y', $request->input('event_date_from'))->format('Y-m-d');
        $event->event_date_2 = $request->input('event_date_to') ? Carbon::createFromFormat('d/m/Y', $request->input('event_date_to'))->format('Y-m-d') : NULL;
        $event->organizer = $request->input('organizer');
        $event->event_link = $request->input('event_link');
        $event->description = $request->input('details');
        $event->status = $request->input('status') ? $request->input('status') : 0;
        $event->meta_title = $request->input('meta_title');
        $event->meta_description = $request->input('meta_description');
        $event->edited_by = Auth::id();

        if ($request->input('is_featured')) {
            $event->is_featured = 1;
        } else {
            $event->is_featured = 0;
        }

        if ($request->input('is_educate')) {
            $event->is_educate = 1;
        } else {
            $event->is_educate = 0;
        }

        if ($request->input('is_aboutus')) {
            $event->is_aboutus = 1;
        } else {
            $event->is_aboutus = 0;
        }

        $destinationPath = storage_path('app/public/events');

        if ($request->hasFile('organizer_logo')) {
            $org_logo = $request->file('organizer_logo');
            if ($org_logo) {
                //DELETE OLD IIMAGE
                Storage::delete('public/events/organizer_logos/'.$event->organizer_logo);

                $filename_org_logo = md5(time()).'.'.$org_logo->clientExtension();
                $org_logo_canvas = Image::canvas(156, 156);
                $resize_org_logo = Image::make($org_logo);
                $resize_org_logo->resize(150, 150, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $org_logo_canvas->insert($resize_org_logo, 'center');
                $org_logo_canvas->save($destinationPath.'/organizer_logos/'.$filename_org_logo, 70);
                $event->organizer_logo = $filename_org_logo;
            }
        }

        if ($request->hasFile('event_banner')) {
            $banner = $request->file('event_banner');
            if ($banner) {
                //DELETE OLD IIMAGE
                Storage::delete(['public/events/thumbs/'.$event->event_banner, 'public/events/banners/'.$event->event_banner]);

                $filename_banner = md5(time()).'.'.$banner->clientExtension();
                $resize_banner = Image::make($banner);
                $resize_banner->fit(360, 200, function ($constraint_banner1) {
                    $constraint_banner1->upsize();
                });
                $resize_banner->save($destinationPath.'/thumbs/'.$filename_banner, 70);
                $resize_banner->fit(640, 640, function ($constraint_banner) {
                    $constraint_banner->upsize();
                });
                $resize_banner->save($destinationPath.'/banners/'.$filename_banner, 70);
                $event->event_banner = $filename_banner;
            }
        }   
        $event->save();

        if ($request->has('categories')) {
            if (!empty($event->category_tag)) {
                $event->category_tag()->delete();
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
            $event->category_tag()->createMany($arr_categories);
        }

        return redirect()->route('admin.events-activities.index')->with('status', 'Event successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        @unlink($destinationPath.'/organizer_logo/'.$event->organizer_logo);
        @unlink($destinationPath.'/banner/'.$event->event_banner);
        $event->delete();

        return redirect()->route('admin.events-activities.index')->with('status', 'Event successfully deleted.');
    }
}

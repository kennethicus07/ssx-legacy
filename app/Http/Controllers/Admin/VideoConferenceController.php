<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Conference;
use App\Models\VideoConference;
use Carbon\Carbon;

class VideoConferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.exhibitions_conferences.videos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $conferences = Conference::where('status', 1)->get();

        return view('admin.exhibitions_conferences.videos.create', compact('conferences'));
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
            'conference' => 'required',
            'url_video' => 'required|url',
            'details' => 'required'
        ]);

        $video = new VideoConference;
        $video->conference_id = $request->input('conference');
        $video->video_link = $request->input('url_video');
        $video->details = $request->input('details');
        $video->status = $request->input('status') ? $request->input('status') : 0;

        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user|shorts)\/))([^\?&\"'>]+)/", $request->input('url_video'), $matches);
        
        if (!empty($matches[1])) {
            $video->video_id = $matches[1];
        }

        $video->added_by = Auth::id();
        $video->save();

        return redirect()->route('admin.conferences-videos.index')->with('status', 'Conference video successfully saved.');
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

        $videos = VideoConference::whereNotNull('conference_id');

        if ($request->has('filter')) {
            $filters = json_decode($request->input('filter'), true);
            if (!empty($filters['conference'])) {
                $videos->where('conference_id', $filters['conference']);
            }
        }

        if ($request->has('sort')) {
            $sort = json_decode($request->input('sort'), true);
            $videos->orderBy("{$sort['field']}", "{$sort['type']}");
        }

        $total_videos = $videos->count();

        $records = $videos->offset($offset)->limit($no_of_records_per_page)->get();

        $arr_videos = [];
        foreach ($records as $video) {
            $arr_videos[] = [
                'id' => $video->id,
                'video_link' => $video->video_link,
                'conference' => $video->conference->title,
                'status' => $video->status,
                'created_at' => $video->created_at,
                'updated_at' => $video->updated_at
            ];
        }

        $arr_permissions = [
            'can_view' => Auth::user()->can('view video'),
            'can_edit' => Auth::user()->can('edit video'),
            'can_add' => Auth::user()->can('add video'),
            'can_delete' => Auth::user()->can('delete video')
        ];

        return response()->json(['total' => $total_videos, 'data' => $arr_videos, 'permissions' => $arr_permissions], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $video = VideoConference::findOrFail($id);
        $conferences = Conference::where('status', 1)->get();

        return view('admin.exhibitions_conferences.videos.update', compact('conferences','video'));
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
        $video = VideoConference::findOrFail($id);

        $request->validate([
            'conference' => 'required',
            'url_video' => 'required|url',
            'details' => 'required'
        ]);

        $video->conference_id = $request->input('conference');
        $video->video_link = $request->input('url_video');
        $video->details = $request->input('details');
        $video->status = $request->input('status') ? $request->input('status') : 0;

        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user|shorts)\/))([^\?&\"'>]+)/", $request->input('url_video'), $matches);
        
        if (!empty($matches[1])) {
            $video->video_id = $matches[1];
        }

        $video->edited_by = Auth::id();
        $video->save();

        return redirect()->route('admin.conferences-videos.index')->with('status', 'Conference video successfully updated.');
    }   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $video = VideoConference::findOrFail($id);
        $video->delete();
        return response()->json(true, 200);
    }
}

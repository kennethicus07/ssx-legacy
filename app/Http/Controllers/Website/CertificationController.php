<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Certification;
use Meta;

class CertificationController extends Controller
{
    public function index()
    {
        $meta_tag = DB::table('seo_meta_tags_pages')->where('page', '=', 'certifications')->first();
        
        Meta::title($meta_tag->meta_title);
        Meta::set('robots', $meta_tag->meta_robots);
        Meta::set('keywords', $meta_tag->meta_keywords);
        Meta::set('description', $meta_tag->meta_description);
        if (!empty($meta->meta_author)) {
            Meta::set('author', $meta_tag->meta_author);
        }
        if (!empty($meta->meta_image)) {
            Meta::set('image', asset('storage/app/public/meta_images/'.$meta->meta_image));
        }
        Meta::set('canonical', url()->current());

        return view('website.certifications.index');
    }

    public function search($qry)
    {
        $certifications = Certification::where('status', 1)->where('name', 'like', '%'.$qry.'%')->get();

        return response()->json($certifications, 200);
    }

    public function list(Request $request)
    {
        $certifications = Certification::where('status', 1)->where('name', '<>', 'Others');

        if (!empty($request->input('qry'))) {
            $certifications->where('name', 'like', '%'.$request->input('qry').'%');
        }

        if (!empty($request->input('sort'))) {
            $certifications->where('name', 'like', $request->input('sort').'%')->orderBy('name', 'asc');
        } else {
            $certifications->orderBy('name', 'asc');
        }
        //echo $certifications->toSql(); exit;
        $res_certifications = $certifications->get();

        $current_letter = '';
        $arr_certifications = [];
        foreach ($res_certifications as $item) {
            $first_letter = mb_substr($item->name, 0, 1, "UTF-8"); 
            if ($first_letter != $current_letter) {
                $arr_certifications[$first_letter][] = $item;
            }
        }
        
        return response()->json($arr_certifications, 200);
    }
}

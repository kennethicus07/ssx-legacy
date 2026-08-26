<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class CompanySustainable implements ToCollection, WithHeadingRow
{
    
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            
            DB::table('users')->where('email', '=', $row['co_email'])->update(['solution_type' => $row['type']]);
            DB::table('exhibitors')->where('co_email', '=', $row['co_email'])->update(['co_details' => $row['co_details']]);
        }
        // return new User([
        //     //
        // ]);
        // if (!empty($row['banner'])) {
        //     $banner = preg_replace('/\s+/', '', $row['banner']);
        // }
        // echo $banner;
        //DB::table('users')->where('email', '=', $row['co_email'])->update(['masthead' => $banner]);
        //DB::table('exhibitors')->where('co_email', '=', $row['co_email'])->update(['co_details' => $row['co_details']]);
        
        //return 1;
    }
}

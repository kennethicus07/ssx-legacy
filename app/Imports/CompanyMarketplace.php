<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class CompanyMarketplace implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            
            DB::table('users')->where('email', '=', $row['co_email'])->update(['solution_type' => $row['type']]);
            DB::table('exhibitors')->where('co_email', '=', $row['co_email'])->update(['co_details' => $row['co_details']]);
        }
    }
}

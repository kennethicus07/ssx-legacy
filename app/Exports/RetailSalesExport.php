<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RetailSalesExport implements FromArray, WithHeadings
{
    protected $rows;

    public function __construct(array $rows)
    {
        $this->rows = $rows;
    }

    public function array(): array
    {
        return $this->rows;
    }

    public function headings(): array
    {
        return [
            'Fair Code',
            'Event',
            'Supplier',
            'Buyer',
            'Buyer Type',
            'Product / Service',
            'Retail Sales',
            'Date of Sale',
        ];
    }
}
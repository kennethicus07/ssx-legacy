<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class SalesActivitySheetExport implements
    FromArray,
    WithHeadings,
    WithTitle
{
    protected $title;
    protected $headings;
    protected $rows;

    public function __construct(
        string $title,
        array $headings,
        array $rows
    ) {
        $this->title = $title;
        $this->headings = $headings;
        $this->rows = $rows;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function headings(): array
    {
        return $this->headings;
    }

    public function array(): array
    {
        return $this->rows;
    }
}
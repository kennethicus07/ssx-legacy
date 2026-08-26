<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class GeneralSummaryMultiSheetExport implements WithMultipleSheets
{
    protected $exportRows;
    protected $domesticRows;
    protected $retailRows;
    protected $inquiryRows;

    public function __construct(
        array $exportRows,
        array $domesticRows,
        array $retailRows,
        array $inquiryRows
    ) {
        $this->exportRows = $exportRows;
        $this->domesticRows = $domesticRows;
        $this->retailRows = $retailRows;
        $this->inquiryRows = $inquiryRows;
    }

    public function sheets(): array
    {
        return [
            new SalesActivitySheetExport(
                'Export Sales',
                [
                    'Company',
                    'Date',
                    'Product / Service',
                    'Buyer Company',
                    'Country',
                    'Booked',
                    'Under Negotiation',
                    'Fair Code',
                ],
                $this->exportRows
            ),

            new SalesActivitySheetExport(
                'Domestic Sales',
                [
                    'Company',
                    'Date',
                    'Product / Service',
                    'Buyer Company',
                    'Buyer Type',
                    'Booked',
                    'Under Negotiation',
                    'Fair Code',
                ],
                $this->domesticRows
            ),

            new SalesActivitySheetExport(
                'Retail Sales',
                [
                    'Company',
                    'Date',
                    'Product / Service',
                    'Buyer Type',
                    'Retail Sales',
                    'Fair Code',
                ],
                $this->retailRows
            ),

            new SalesActivitySheetExport(
                'Inquiries',
                [
                    'Company',
                    'Date',
                    'No. of Inquiries',
                    'No. of Buyers Met',
                    'Fair Code',
                ],
                $this->inquiryRows
            ),
        ];
    }
}
<?php

namespace App\Excel;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class YearlyReport implements FromCollection, WithHeadings, ShouldAutoSize
{
    use Exportable;

    private $reportCollection;

    public function __construct(Collection $reportCollection) {
        $this->reportCollection = $reportCollection;
    }

    public function collection() {
        return $this->reportCollection;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Date',
            'Invoice ID',
            'Tax Invoice ID',
            'Product Name',
            'Quantity',
            'Discount Include VAT',
            'Price Include VAT',
            'Total Include VAT',
            'Tax Base',
            'VAT',
            'Tax Invoice Credited Date',
            'Tax Invoice Date',
            'Tax Invoice No'
        ];
    }
}
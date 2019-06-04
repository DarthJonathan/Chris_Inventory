<?php

namespace App\Excel;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class YearlyReport implements FromCollection
{
    use Exportable;

    private $reportCollection;

    public function __construct(Collection $reportCollection) {
        $this->reportCollection = $reportCollection;
    }

    public function collection() {
        return $this->reportCollection;
    }
}
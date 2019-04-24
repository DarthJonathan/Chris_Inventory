<?php

namespace App\Excel\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportExport implements FromCollection
{
    public function collection()
    {
        return User::all();
    }
}
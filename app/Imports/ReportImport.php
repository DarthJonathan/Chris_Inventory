<?php

namespace App\Imports;


use App\Datamodels\ReportExcel;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;

class ReportImport implements ToModel
{
    /**
     * @param array $row
     * @return ReportExcel|Model|Model[]|null
     */
    public function model(array $row) : ReportExcel
    {
        return new ReportExcel([
            'date'                      => $row[0],
            'invoice_id'                => $row[1],
            'tax_invoice_id'            => $row[2],
            'product_name'              => $row[3],
            'quantity'                  => $row[4],
            'discount'                  => $row[5],
            'price'                     => $row[6],
            'tax_invoice_credited_date' => $row[7],
            'tax_invoice_date'          => $row[8],
            'tax_invoice_no'            => $row[9],
            'total'                     => $row[10],
            'tax_base'                  => $row[11],
            'VAT'                       => $row[12]
        ]);
    }
}
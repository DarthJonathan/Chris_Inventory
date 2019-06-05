@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <h2 class="c-grey-900 mT-10 mB-30">Yearly {{ ucfirst($type) }} Report</h2>
        </div>
        <div class="col-lg-4 row">
            <div class="col-md-4 d-flex align-items-center">
                <a href="{{ "/report/export/yearly/" . $type . '/' . Carbon\Carbon::now()->year }}" data-type="{{ $type }}" id="export-excel" class="btn btn-primary">
                    Export Excel
                </a>
            </div>
            <div class="col-md-8 d-flex align-items-center">
                <select id="year" class="form-control">
                    <option value="{{ Carbon\Carbon::now()->year }}">{{ Carbon\Carbon::now()->year }}</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover" id="yearlyReportTable" data-type="{{$type}}">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Invoice No</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price (Include VAT)</th>
                            <th>Discount (Include VAT)</th>
                            <th>Total (Include VAT)</th>
                            <th>Tax Base</th>
                            <th>VAT</th>
                            <th>Tax Invoice</th>
                            <th>Tax Invoice Date</th>
                            <th>Credited In VAT Period</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
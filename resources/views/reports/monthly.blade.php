@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-10">
            <h2 class="c-grey-900 mT-10 mB-30">Monthly {{ ucfirst($type) }} Report</h2>
        </div>
        <div class="col-lg-2">
            <select id="month" class="form-control mt-3">
                <option value="{{ Carbon\Carbon::now()->month . '/' . Carbon\Carbon::now()->year }}">{{ Carbon\Carbon::now()->monthName . ' ' . Carbon\Carbon::now()->year }}</option>
            </select>
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
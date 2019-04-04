@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-10">
            <h2 class="c-grey-900 mT-10 mB-30">Yearly {{ ucfirst($type) }} Report</h2>
        </div>
        <div class="col-lg-2">
            <select id="year" class="form-control mt-3">
                <option value="{{ Carbon\Carbon::now()->year }}">{{ Carbon\Carbon::now()->year }}</option>
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
                            <th>Invoice No</th>
                            <th>Sale Date</th>
                            <th>Tax Invoice</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th style="width: 15%">Action</th>
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
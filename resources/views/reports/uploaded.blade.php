@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <h2 class="c-grey-900 mT-10 mB-30">Uploaded Report Preview</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover" id="uploadedReportTable">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Invoice No</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price (Include VAT)</th>
                            <th>Discount (Include VAT)</th>
                            <th>Total (Include VAT)</th>
                            <th>Customer</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $report)
                                <tr>
                                    <td>{{\Carbon\Carbon::parse($report->date)->toDateString()}}</td>
                                    <td>{{ $report->invoice_id }}</td>
                                    <td>{{ $report->product_name }}</td>
                                    <td>{{ $report->quantity }}</td>
                                    <td>Rp. {{ number_format($report->price) }},-</td>
                                    <td>Rp. {{ number_format($report->discount) }},-</td>
                                    <td>Rp. {{ number_format(($report->price - $report->discount) * $report->quantity) }},-</td>
                                    <td>{{ $report->customer }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
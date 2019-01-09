@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <h2 class="c-grey-900 mT-10 mB-30">Sales</h2>
    </div>
    <div class="col-lg-4 text-right">
        <a href="{{ url('sales/new') }}" class="btn btn-primary mt-2">
            New Sale
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover" id="salesTable">
                    <thead>
                        <tr>
                            <th>Invoice No</th>
                            <th>Sale Date</th>
                            <th>Tax Invoice</th>
                            <th style="width: 15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{--@foreach($sales as $count => $sale)--}}
                            {{--<tr>--}}
                                {{--<td>{{ $count+1 }}</td>--}}
                                {{--<td>{{ $sale->invoice_id }}</td>--}}
                                {{--<td>{{ \Carbon\Carbon::parse($sale->created_at)->format("D, d M Y") }}</td>--}}
                                {{--<td>{{ $sale->taxInvoice != null ? $sale->taxInvoice->invoice_no : 'NONE' }}</td>--}}
                                {{--<td>--}}
                                    {{--<a href="/sales/detail/{{ $sale->id }}" class="btn btn-primary btn-block">Details</a>--}}
                                    {{--<br>--}}
                                    {{--<button class="btn btn-danger btn-block">Delete</button>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                        {{--@endforeach--}}
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Invoice No</th>
                            <th>Sale Date</th>
                            <th>Tax Invoice</th>
                            <th style="width: 15%">Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>  
</div>
@endsection
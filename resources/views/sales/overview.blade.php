@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h1>Sales</h1>
                <a href="{{ url('sales/new') }}" class="btn btn-primary float-right btn-lg">
                    New Sale
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover table-fit-parent">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Invoice No</th>
                            <th>Product</th>
                            <th>Sale Date</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Tax Invoice</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales as $count => $sale)
                            <tr>
                                <td>{{ $count+1 }}</td>
                                <td>{{ $sale->invoice_no }}</td>
                                <td>{{ $sale->product->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($sale->sales_date)->format("LLLL") }}</td>
                                <td>Rp. {{ number_format($sale->price) }}</td>
                                <td>{{ $sale->discount }}</td>
                                <td>{{ $sale->taxInvoice != null ? $sale->taxInvoice->invoice_no : 'NONE' }}</td>
                                <td>
                                    <button class="btn btn-primary btn-block">Edit</button>
                                    <br>
                                    <button class="btn btn-danger btn-block">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8">
                                <div class="float-right">
                                    {{ $sales->links() }}
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>  
</div>
@endsection
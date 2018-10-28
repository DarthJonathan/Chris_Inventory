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
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Invoice No</th>
                            <th>Sale Date</th>
                            <th>Tax Invoice</th>
                            <th style="width: 15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales as $count => $sale)
                            <tr>
                                <td>{{ $count+1 }}</td>
                                <td>{{ $sale->invoice_id }}</td>
                                <td>{{ \Carbon\Carbon::parse($sale->created_at)->format("LLLL") }}</td>
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
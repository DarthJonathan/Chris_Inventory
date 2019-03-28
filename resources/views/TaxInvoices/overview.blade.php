@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body row">
                    <div class="col-md-8">
                        <h1>Tax Invoices</h1>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ url('taxinvoices/new') }}" class="btn btn-primary float-right">
                            New Tax Invoice
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <table id="taxInvoiceTable" class="table table-hover" style="width: 100%; table-layout: fixed">
                        <thead>
                        <tr>
                            <th style="width: 20%;">Invoice No</th>
                            <th>Date</th>
                            <th>Cashed</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{--@foreach($taxinvoices as $index => $taxinvoice)--}}
                            {{--<tr>--}}
                                {{--<td>{{ $index+1 }}</td>--}}
                                {{--<td>{{ $taxinvoice->invoice_no }}</td>--}}
                                {{--<td>{{ $taxinvoice->date }}</td>--}}
                                {{--<td>{{ $taxinvoice->used }}</td>--}}
                                {{--<td>--}}
                                    {{--<button class="btn btn-primary">--}}
                                        {{--Edit--}}
                                    {{--</button>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                        {{--@endforeach--}}
                        </tbody>
                        <tfoot>
                        <tr>
                            <th style="width: 20%;">Invoice No</th>
                            <th>Date</th>
                            <th>Cashed</th>
                            <th>Actions</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
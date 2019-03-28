@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 mx-auto">
            <div class="card">
                <div class="card-body">
                    <a href="/taxinvoices" class="btn btn-primary float-right">Return</a>
                    <a href="/taxinvoices/edit/{{ $tax_invoice->id }}" class="btn btn-primary float-right mr-3">Edit</a>
                    <h1>Tax Invoice No. {{ $tax_invoice->invoice_no }}</h1>
                    <table class="table table-hover">
                        <tr>
                            <th>Invoice No</th>
                            <td>{{ $tax_invoice->invoice_no }}</td>
                        </tr>
                        <tr>
                            <th>Invoice Year</th>
                            <td>{{ \Carbon\Carbon::parse($tax_invoice->date)->year }}</td>
                        </tr>
                        <tr>
                            <th>Tax Invoice Cashed</th>
                            <td>
                                @if($tax_invoice->used)
                                    <button class="btn btn-success">Yes</button>
                                @else
                                    <button class="btn btn-warning">No</button>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Customer</th>
                            <td>
                                {{ $tax_invoice->customer == null ? 'Not tied to a customer' : $tax_invoice->customer->name }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
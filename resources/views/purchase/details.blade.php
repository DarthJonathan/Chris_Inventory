@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <a href="/purchases" class="btn btn-primary float-right">Return</a>
                    <h1>Transaction No. {{ $transaction->invoice_id }}</h1>
                    <table class="table table-hover">
                        <tr>
                            <th>Invoice No</th>
                            <td>{{ $transaction->invoice_id }}</td>
                        </tr>
                        <tr>
                            <th>Tax Invoice</th>
                            <td>{{ $transaction->taxInvoice ? $transaction->taxInvoice->invoice_no : 'No Tax Invoice Yet' }}</td>
                        </tr>
                        <tr>
                            <th>Tax Invoice Cashed</th>
                            <td>
                                @if($transaction->taxInvoice)
                                    @if($transaction->taxInvoice->used)
                                        <button class="btn btn-success">Yes</button>
                                    @else
                                        <button class="btn btn-warning">No</button>
                                    @endif
                                @else
                                    <button class="btn btn-warning">No Tax Invoice</button>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Customer</th>
                            <td>PT. Byteforce</td>
                        </tr>
                    </table>
                    <hr>
                    <h3>Items</h3>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price Per Item</th>
                            <th>Discount</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($transaction->purchases as $count => $purchase)
                                <tr>
                                    <td>{{ $count+1 }}</td>
                                    <td>
                                        {{ $purchase->product->product_name }}
                                    </td>
                                    <td>
                                        {{ $purchase->quantity }}
                                    </td>
                                    <td>
                                        {{ $purchase->price }}
                                    </td>
                                    <td>
                                        {{ $purchase->discount }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
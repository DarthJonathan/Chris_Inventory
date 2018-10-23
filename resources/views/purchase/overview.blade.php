@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h1>Purchases</h1>
                <a href="{{ url('purchases/new') }}" class="btn btn-primary float-right btn-lg">
                    New Purchase
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
                            <th>Invoice No.</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price per Item</th>
                            <th>Discount</th>
                            <th>Purchase Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchases as $key => $purchase)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $purchase->invoice }}</td>
                                <td>{{ $purchase->product->product_name }}</td>
                                <td>{{ $purchase->quantity }}</td>
                                <td>{{ $purchase->price }}</td>
                                <td>{{ $purchase->discount }}</td>
                                <td>{{ $purchase->purchase_date }}</td>
                                <td>
                                    <a href="/purchases/edit/{{ $purchase->id }}" class="btn btn-primary">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8">
                                <div class="float-right">
                                    {{ $purchases->links() }}
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
@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <h2 class="c-grey-900 mT-10 mB-30">Purchases</h2>
    </div>
    <div class="col-lg-4 text-right">
        <a href="{{ url('purchases/new') }}" class="btn btn-primary mt-2">
            New Purchase
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover" id="purchasesTable">
                    <thead>
                        <tr>
                            <th>Invoice No.</th>
                            <th>Tax Invoice No.</th>
                            <th>Purchase Date</th>
                            <th style="width: 15%">Action</th>
                        </tr>
                    </thead>
                    {{--<tbody>--}}
                        {{--@foreach($purchases as $key => $purchase)--}}
                            {{--<tr>--}}
                                {{--<td>{{ $key+1 }}</td>--}}
                                {{--<td>{{ $purchase->invoice_id }}</td>--}}
                                {{--<td>{{ $purchase->taxInvoice ? $purchase->taxInvoice ->invoice_no : 'No Tax Invoice' }}</td>--}}
                                {{--<td>{{ \Carbon\Carbon::parse($purchase->created_at)->format("D, d M Y") }}</td>--}}
                                {{--<td>--}}
                                    {{--<a href="/purchases/details/{{ $purchase->id }}" class="btn btn-primary">Details</a>--}}
                                    {{--<a href="/purchases/edit/{{ $purchase->id }}" class="btn btn-primary">Edit</a>--}}
                                    {{--<form action="/purchases/delete" method="post">--}}
                                        {{--@csrf--}}
                                        {{--<input type="hidden" name="id" value="{{ $purchase->id }}">--}}
                                        {{--<button class="btn btn-danger">Delete</button>--}}
                                    {{--</form>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                        {{--@endforeach--}}
                    {{--</tbody>--}}
                    <tfoot>
                        <tr>
                            <th>Invoice No.</th>
                            <th>Tax Invoice No.</th>
                            <th>Purchase Date</th>
                            <th style="width: 15%">Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>  
</div>
@endsection
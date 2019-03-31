@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form class="forms-sample" method="post" action="{{ url('/taxinvoices/edit') }}">
                        @csrf

                        <input type="hidden" name="id" value="{{ $taxinvoice->id }}">

                        <div id="editTaxInvoiceComponent" data-taxinvoice='{!! json_encode($taxinvoice) !!}'></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
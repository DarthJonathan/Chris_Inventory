@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h2 class="c-grey-900 mT-10 mB-30">New Invoice</h2>
        </div>
    </div>
    <div class="row justify-content-center">
        <form class="forms-sample" method="post" action="{{ url('/invoice/generate') }}">
            @csrf
            <div id="newPurchaseForm"></div>
        </form>
    </div>
@endsection

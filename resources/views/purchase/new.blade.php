@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="post" action="{{ url('/purchases/new') }}">
                    @csrf
                    <div id="newPurchaseForm"></div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
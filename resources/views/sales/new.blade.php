@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form class="forms-sample" method="post" action="{{ url('/sales/new') }}">

                        @csrf

                        <div id="newSalesComponent"></div>

                        <div class="float-right">
                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                            <a href="/sales" type="reset" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
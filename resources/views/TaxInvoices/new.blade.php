@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form class="forms-sample" method="post" action="{{ url('/customers/new') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="date" class="col-sm-3 col-form-label">Invoice No</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="invoiceno" name="invoiceno" placeholder="Enter Invoice No">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date" class="col-sm-3 col-form-label">Date</label>
                            <div class="col-sm-9">
                                <input type="date" name="date" id="date" class="form-control" placeholder="Enter Date">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date" class="col-sm-3 col-form-label">Cashed</label>
                            <div class="col-sm-9">
                                <div class="form-check d-flex">
                                    <input type="radio" name="cashed" id="cashed_true" value="true" class="form-check-input">
                                    <label for="cashed_true" class="form-check-label">Cashed</label>
                                </div>
                                <div class="form-check d-flex">
                                    <input type="radio" name="cashed" id="cashed_false" value="false" class="form-check-input">
                                    <label for="cashed_false" class="form-check-label">Not Cashed Yet</label>
                                </div>
                            </div>
                        </div>

                        <div class="float-right">
                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                            <button type="reset" class="btn btn-light">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form class="forms-sample" method="post" action="{{ url('/customers/new') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="date" class="col-sm-3 col-form-label">Customer Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date" class="col-sm-3 col-form-label">Address</label>
                            <div class="col-sm-9">
                                <textarea name="address" placeholder="Address" class="form-control" id="address" cols="30" rows="10"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date" class="col-sm-3 col-form-label">Phone</label>
                            <div class="col-sm-9">
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date" class="col-sm-3 col-form-label">Detail</label>
                            <div class="col-sm-9">
                                <textarea name="detail" placeholder="Detail" class="form-control" id="detail" cols="30" rows="10"></textarea>
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
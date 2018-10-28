@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form class="forms-sample" method="post" action="{{ url('/products/new') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="date" class="col-sm-3 col-form-label">Product Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date" class="col-sm-3 col-form-label">Product Stock</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="name" name="stock" placeholder="Enter Stock">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date" class="col-sm-3 col-form-label">Product Average Price Now</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="name" name="average_price" placeholder="Enter Mean Price">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date" class="col-sm-3 col-form-label">Product Desciption</label>
                            <div class="col-sm-9">
                                <textarea name="desc" id="desc" cols="30" rows="10" class="form-control"></textarea>
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
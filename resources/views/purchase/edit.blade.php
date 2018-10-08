@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form class="forms-sample" method="post" action="{{ url('/purchases/new') }}">

                        @csrf

                        <div class="form-group row">
                            <label for="date" class="col-sm-3 col-form-label">Date*</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="date" name="date" placeholder="Enter date">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="invoicenumber" class="col-sm-3 col-form-label">Invoice Number*</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="invoicenumber" name="invoice" placeholder="Invoice">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price" class="col-sm-3 col-form-label">Item*</label>
                            <div class="col-sm-9">
                                <input type="num" step="1" min="1" class="form-control" id="item" name="item" placeholder="Item">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price" class="col-sm-3 col-form-label">Price per Item*</label>
                            <div class="col-sm-9">
                                <input type="num" step="0.1" min="0" class="form-control" id="price" name="itemprice" placeholder="Price">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price" class="col-sm-3 col-form-label">Discount*</label>
                            <div class="col-sm-9">
                                <input type="num" step="0.1" min="0" class="form-control" id="discount" name="discount" placeholder="Discount">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <hr>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="invoicenumber" class="col-sm-3 col-form-label">Tax Invoice</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="taxinvoice" name="taxinvoice" placeholder="Tax Invoice">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="invoicenumber" class="col-sm-3 col-form-label">Tax Invoice Date</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="date_2" name="taxinvoicedate" placeholder="Tax Invoice Date">
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
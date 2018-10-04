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
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Product</th>
                                <th>Sale</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Jacob</td>
                                <td>Photoshop</td>
                                <td class="text-danger"> 28.76%
                                    <i class="mdi mdi-arrow-down"></i>
                                </td>
                                <td>
                                    <label class="badge badge-danger">Pending</label>
                                </td>
                                </tr>
                            <tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>  
</div>
@endsection
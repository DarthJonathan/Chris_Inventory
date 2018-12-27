@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body row">
                    <div class="col-md-8">
                        <h1>Customers</h1>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ url('customers/new') }}" class="btn btn-primary float-right">
                            New Customer
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover" style="width: 100%; table-layout: fixed">
                        <thead>
                        <tr>
                            <th style="width: 7%;">No</th>
                            <th style="width: 20%;">Customer Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Details</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($customers as $index => $inventory)
                            <tr>
                                <td>{{ $index+1 }}</td>
                                <td>{{ $inventory->name }}</td>
                                <td>{{ $inventory->address }}</td>
                                <td>{{ $inventory->phone }}</td>
                                <td>{{ $inventory->email }}</td>
                                <td>{{ $inventory->details }}</td>
                                <td>
                                    <button class="btn btn-primary">
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="4">
                                <div class="float-right">
                                    {{ $customers->links() }}
                                </div>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')

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
                <div class="card-body">
                    <table class="table table-hover" style="width: 100%; table-layout: fixed" id="customerTable">
                        <thead>
                        <tr>
                            <th style="width: 20%;">Customer ID</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Details</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{--@foreach($customers as $index => $inventory)--}}
                            {{--<tr>--}}
                                {{--<td>{{ $index+1 }}</td>--}}
                                {{--<td>{{ $inventory->name }}</td>--}}
                                {{--<td>{{ $inventory->address }}</td>--}}
                                {{--<td>{{ $inventory->phone }}</td>--}}
                                {{--<td>{{ $inventory->email }}</td>--}}
                                {{--<td>{{ $inventory->details }}</td>--}}
                                {{--<td>--}}
                                    {{--<button class="btn btn-primary">--}}
                                        {{--Edit--}}
                                    {{--</button>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                        {{--@endforeach--}}
                        </tbody>
                        <tfoot>
                        <tr>
                            <th style="width: 7%;">Customer ID</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Details</th>
                            <th>Actions</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
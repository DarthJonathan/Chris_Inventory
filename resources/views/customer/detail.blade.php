@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body row">
                    <div class="col-md-12 mb-3 ml-2">
                        <h2>Customers</h2>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-hover" style="width: 100%; table-layout: fixed">
                            <tr>
                                <th>Name</th>
                                <td>{{ __($customer_detail->name) }}</td>
                            </tr>

                            <tr>
                                <th>Address</th>
                                <td>{{ __($customer_detail->address) }}</td>
                            </tr>

                            <tr>
                                <th>Phone</th>
                                <td>{{ __($customer_detail->phone) }}</td>
                            </tr>

                            <tr>
                                <th>Email</th>
                                <td>{{ __($customer_detail->email) }}</td>
                            </tr>

                            <tr>
                                <th>Details</th>
                                <td>{{ __($customer_detail->details) }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-12 mb-3 ml-2 text-right d-flex align-items-end justify-content-end">
                        <a href="/customers/edit/{{ $customer_detail->id }}" class="btn btn-outline-dark px-5 mr-3">
                            Edit
                        </a>
                        <form action="/customers/delete" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $customer_detail->id }}">
                            <button class="btn btn-danger px-5 mr-2">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

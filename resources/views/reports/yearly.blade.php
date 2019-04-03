@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <h2 class="c-grey-900 mT-10 mB-30">Yearly Report</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover" id="salesTable">
                        <thead>
                        <tr>
                            <th>Invoice No</th>
                            <th>Sale Date</th>
                            <th>Tax Invoice</th>
                            <th style="width: 15%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
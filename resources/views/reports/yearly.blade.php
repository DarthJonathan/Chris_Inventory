@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-10">
            <h2 class="c-grey-900 mT-10 mB-30">Yearly Report</h2>
        </div>
        <div class="col-lg-2">
            <select id="year" class="form-control mt-3">
                <option value="2019">2019</option>
                <option value="2018">2018</option>
                <option value="2017">2017</option>
                <option value="2016">2016</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover" id="yearlyReportTable" data-type="{{$type}}">
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
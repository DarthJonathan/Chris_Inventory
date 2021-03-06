@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h2 class="c-grey-900 mT-10 mB-30">Import Excel</h2>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <h2>Import</h2>
            <form action="/import" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="type">Type</label>
                    <select class="custom-select" id="type" name="type">
                        <option value="sales">Sales</option>
                        <option value="purchases">Purchases</option>
                    </select>
                </div>
                <div class="custom-file">
                    <input type="file" name="import" class="custom-file-input" id="import">
                    <label class="custom-file-label" for="import">Choose file</label>
                </div>
                <button type="submit" class="btn btn-primary float-right mt-4">Submit</button>
            </form>
        </div>
    </div>
@endsection
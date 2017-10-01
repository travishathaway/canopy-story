@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="ml-auto col-sm-12 col-lg-8 mr-auto">
      <h1 class="mt-4">Admin</h1>
      <hr>
      <h3 class="mb-3">Download Response Data</h3>
      <p>Download all canopy stories that have been submitted so far</p>
      <a href="{{ route('admin.response_data') }}?type=csv" class="btn btn-primary">Download CSV</a>
      <a href="{{ route('admin.response_data') }}?type=xls" class="btn btn-primary">Download Excel</a>
    </div>
  </div>
@endsection


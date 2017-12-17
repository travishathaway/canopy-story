@extends('layouts.index')

@section('title', 'Canopy Stories')

@section('content')
<div class="container-fluid index-page">
    <!-- First Block Section (Desktop) -->
    <div class="d-none d-sm-block">
    @include('partials.index.first-block-desktop')
    </div>

    <!-- First Block Section (Mobile) -->
    <div class="d-sm-none">
    @include('partials.index.first-block-mobile')
    </div>

    <hr>
    <!-- Begin Column'd layout Section -->
    <div class="row">
        <div class="col-md">
            <h2>Our Sponsors</h2>
        </div>
        <div class="col-md">
            <h2>Oh hai, some moar</h2>
        </div>
    </div>
    <!-- End Column'd layout Section -->
</div>
@endsection

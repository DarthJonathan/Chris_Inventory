<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Title --}}
    <title>Sales System - Byteforce Indonesia</title>

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" async></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
{{-- Navbar --}}
@include('layouts/partials/navbar')

{{--Notifications--}}
@if(session('success'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

@if(count($errors->all()) > 0)
    @foreach($errors->all() as $error)
        <div class="alert alert-danger">
            {{ $error }}
        </div>
    @endforeach
@endif

{{--Begin Content--}}
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper">
        {{-- Sidebar --}}
        @include('layouts/partials/sidebar')
        <div class="main-panel">
            <div class="content-wrapper">
                @yield('content')
            </div>
            {{-- Footer --}}
            @include('layouts/partials/footer')
        </div>
    </div>
</div>
@yield('additional_javascript')
</body>
</html>
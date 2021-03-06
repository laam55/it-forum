<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta content="{{ csrf_token() }}" name="csrf-token">
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <title>Admin IT-FORUM</title>
    
    @yield('link-header')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

</head>
<body id="page-top">
    @include('admin.layout.header')
    <div id="wrapper">
        @include('admin.layout.sidebar')
        <div id="content-wrapper">
            <div class="container-fluid" id="content">
                @yield('content')
            </div>
        </div>
    </div>
    @include('admin.layout.logout')

    <script src="{{ asset('js/manifest.js') }}"></script>
    <script src="{{ asset('js/vendor.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    @yield('script')
</body>
</html>

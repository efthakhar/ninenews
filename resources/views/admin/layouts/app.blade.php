<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>9news</title>

    <link rel="stylesheet" href="{{asset('common/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('common/icon-font/remix/remixicon.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/dashboard-core.css')}}">
    
</head>

<body>
    <div class="admin-page">

        @include('admin.partials.sidebar', $navlinks = get_sidebar_navlinks())

        <div class="admin-main">
            @include('admin.partials.header')
            <div class="admin-content">
            @yield('content')
            </div>
        </div>

    </div>
    
    <script src="{{asset('common/js/jquery.js')}}"></script>
    <script src="{{asset('common/js/bootstrap.js')}}"></script>

    <script src="{{asset('assets/admin/js/dashboard-core.js')}}"></script>
    <script src="{{asset('assets/admin/js/global.js')}}"></script>

    @yield('footer-script')
</body>

</html>
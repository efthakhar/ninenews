<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>9news</title>
    @vite('resources/assets/common/css/bootstrap.css')
    @vite('resources/assets/admin/css/dashboard-core.css')
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
    @vite('resources/assets/common/js/jquery.js')
    @vite('resources/assets/common/js/bootstrap.js')
    @vite('resources/assets/admin/js/dashboard-core.js')
</body>

</html>
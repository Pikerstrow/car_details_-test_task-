<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
          integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link href="{{asset('css/libs.css')}}" rel="stylesheet">
    <title>@yield('title')</title>
</head>
<body>
    @include('admin.layouts.parts.delete-modal')
    <aside class="sidebar-nav">
        @include('admin.layouts.parts.sidebar')
    </aside>
    <section class="main-content">
        <div class="row">
            @yield('page_title')
            <hr class="admin-hr-separator">
        </div>
        <div class="row justify-content-center">
            @yield('content')
        </div>
    </section>

    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
</body>
</html>
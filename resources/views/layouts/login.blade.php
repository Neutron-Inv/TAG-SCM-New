
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Enabled Solutions">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> SCM | {{$title}} </title>
    <meta name="description" content="SCM">
    <meta name="author" content="Enabled Solutions">
    <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}" />
    <link rel="stylesheet" href="{{asset('admin/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/fonts/style.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/main.css')}}" />
<head>

<body class="authentication">

    {{--  <div id="loading-wrapper">
        <div class='spinner-wrapper'>
            <div class='spinner'>
                <div class='inner'></div>
            </div>
            <div class='spinner'>
                <div class='inner'></div>
            </div>
            <div class='spinner'>
                <div class='inner'></div>
            </div>
            <div class='spinner'>
                <div class='inner'></div>
            </div>
            <div class='spinner'>
                <div class='inner'></div>
            </div>
            <div class='spinner'>
                <div class='inner'></div>
            </div>
        </div>
    </div>  --}}

    <main class="">
        @yield('content')
    </main>

    <script src="{{asset('admin/js/jquery.min.js')}}"></script>
    <script src="{{asset('admin/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('admin/js/moment.js')}}"></script>

    <script src="{{asset('admin/js/main.js')}}"></script>

</body>
</html>

<!doctype html>
<html lang="en">
<head>
    <title>@yield('title', 'King Bakery') - King Bakery</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{csrf_token()}}">

{{--    標題欄： --}}
    <link rel="icon" href="/images/KB_Logo.jpg" type="image/x-icon" />
{{--    收藏夾：--}}
    <link rel="shortcut icon" href="/images/KB_Logo.jpg" type="image/x-icon" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/css/bootstrap-4.1.2.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/responsive.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="/css/sweetalert2.min.css" id="theme-styles">
    @yield('css')
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="/js/sweetalert2.min.js"></script>
    <script src="/js/jquery-3.3.1.min.js" ></script>
    <script src="/js/TweenMax.min.js"></script>

    {{--<script src="/js/custom.js"></script>--}}
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    @yield('js')
    @yield('style')
</head>
<body>
<!-- BEGIN -->
<div class="wrapper-content">

    <div style="height: 120px"></div>
    <div class="container main">
        <div class="col-sm-12 col-md-12 col-12">

            @include('shared._messages')

            @yield('content')
        </div>
    </div>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    @yield('script')

    @include('layouts._footer')
</div>

@if (config('app.debug'))
    @include('sudosu::user-selector')
@endif
<!-- END  -->

</body>
</html>



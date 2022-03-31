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
    <!-- Header-top -->
    <div class="menu fixed-top">
        <header>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4 col-4">
                        <ul class="list-social row">
                            <li><a href="https://www.facebook.com/Kingbakery" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i></a></li>
                            <li><a href="https://www.instagram.com/kingbakeryhk/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                    <!-- 頂部中間 -->
                    <div class="col-sm-4 col-4 text-center">
                        <span class="time-open"></span>
                    </div>
                    <!-- 登入登出 -->
                    @guest
                        <div class="col-sm-4 col-4 login-reg">
                            <div class="login-reg-inner">
                                <span><i class="fa fa-user    "></i><a href="{{route('login')}}" class="login">LOGIN</a></span>
                            </div>
                        </div>
                    @else
                        <div class="col-sm-4 col-4 login-reg">
                            <div class="login-reg-inner">
                                <span><i class="fa fa-user    "></i><a href="javascript:;" class="login">{{Auth::user()->txt_name}}</a></span>
                                @cannot('shop')
                                |
                                <a class="fa fa-user" href="{{ route('password.reset.login') }}">
                                    修改密碼
                                </a>
                                @endcannot
                                |
                                <a class="fa fa-user" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    登出
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                @endguest
                <!-- 登入登出 -->
                </div>
            </div>
        </header>

        <!-- Navigation -->
    @include('layouts._nav')
    <!-- Navigation -->
    </div>
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



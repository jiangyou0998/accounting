<!doctype html>
<html lang="en">
<head>
    <title>@yield('title', 'Ryoyu Bakery') - Ryoyu Bakery</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{csrf_token()}}">

{{--    標題欄： --}}
    <link rel="icon" href="/images/ryoyu_title_logo.ico" type="image/x-icon" />
{{--    收藏夾：--}}
    <link rel="shortcut icon" href="/images/ryoyu_title_logo.ico" type="image/x-icon" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/responsive.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css" id="theme-styles">
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.0.1/TweenMax.min.js"></script>

    {{--<script src="/js/custom.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
    @yield('js')
    @yield('css')
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
                            <li><a href=""><i class="fa fa-facebook-official" aria-hidden="true"></i></a></li>
                            <li><a href=""><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a href=""><i class="fa fa-google-plus-official" aria-hidden="true"></i></a></li>
                            <li><a href=""><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
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
                                <span><i class="fa fa-user    "></i><a href="javascript:;" class="login">{{Auth::user()->txt_name}}</a></span> |
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



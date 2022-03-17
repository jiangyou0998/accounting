<!-- Navigation -->

<nav class="navbar navbar-expand-lg navbar-light bg-light static-top">
    <div class="container">
        <a class="navbar-brand col-4" href="/">
            <img src="/images/2cafe_logo.png" alt="" width="40%" height="40%">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
{{--                <li class="nav-item active">--}}
{{--                    <a class="nav-link" href="#">Home--}}
{{--                        <span class="sr-only">(current)</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
                @foreach($menus as $menu)
                    @if($menu->parent_id === 0)
                        @include('layouts._nav_item')
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</nav>



{{--            </ul>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</nav>--}}

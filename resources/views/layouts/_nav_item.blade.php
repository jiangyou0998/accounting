<li class="nav-item dropdown">

    @if($menu->allChildrenMenu->count() && Auth::check())
        <a class="nav-link" data-toggle="dropdown" href="{{$menu->uri}}">{{$menu->title}}</a>
        <ul class="dropdown-menu">
            @foreach($menu->allChildrenMenu as $item)
                <li class="list-group-item"><a href="{{$item->uri}}">{{$item->title}}</a></li>
            @endforeach
        </ul>
    @elseif($menu->allChildrenMenu->count())
        <a class="nav-link" href="{{route('login')}}">{{$menu->title}}</a>
    @else
        <a class="nav-link" href="{{$menu->uri}}">{{$menu->title}}</a>
    @endif
</li>

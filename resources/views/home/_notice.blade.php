<section id="services">
    <div class="container">
        <div class="col-md-12 mb-12">
            <h5 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">最新通告</span>
            </h5>
            <ul class="list-group mb-3">
                @foreach($notices as $notice)
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">
                            <small class="text-muted">{{$notice->modify_date}}</small>
                            @guest
                                <a href="{{route('login')}}">
                                    {{$notice->notice_name}}
                                </a>
                            @endguest
                            @auth
                            <a href="{{'/notices/'.$notice->file_path}}">
                                {{$notice->notice_name}}
                            </a>
                            @endauth
                            @if($notice->isNew)
                            <span class="badge badge-danger">New</span>
                            @endif
                        </h6>

                    </div>
                    <span class="text-muted">{{$dept_names[$notice->admin_role_id]}}</span>

                </li>
                @endforeach
            </ul>

        </div>
    </div>
</section>

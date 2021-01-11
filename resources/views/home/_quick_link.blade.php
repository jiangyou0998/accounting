<!-- 快速進入 -->
<h6 class="d-flex justify-content-between align-items-center mb-3">
    <span class="text-muted">快捷進入</span>
</h6>
<ul class="list-group mb-3">

    @guest()
        <li class="list-group-item d-flex justify-content-between lh-condensed">
            <div>
                <h6 class="my-0">
                    <a href="{{route('login')}}">
                        登錄
                    </a>
                </h6>

            </div>

        </li>
    @endguest

    @can('shop')
        <li class="list-group-item d-flex justify-content-between lh-condensed">
            <div>
                <h6 class="my-0">
                    <a href="{{route('order')}}">
                        柯打
                    </a>
                </h6>

            </div>

        </li>

        <li class="list-group-item d-flex justify-content-between lh-condensed">
            <div>
                <h6 class="my-0">
                    <a href="{{route('order.deli')}}" target="_blank" ﻿​>
                        查詢送貨單
                    </a>
                </h6>

            </div>

        </li>
    @endcan

    @can('workshop')

        <li class="list-group-item d-flex justify-content-between lh-condensed">
            <div>
                <h6 class="my-0">
                    <a href="{{route('order.deli.list')}}">
                        改發票
                    </a>
                </h6>

            </div>

        </li>

        <li class="list-group-item d-flex justify-content-between lh-condensed">
            <div>
                <h6 class="my-0">
                    <a href="{{route('order.select_deli')}}" target="_blank" ﻿​>
                        查詢送貨單
                    </a>
                </h6>

            </div>

        </li>
    @endcan

    @can('operation')

            <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                    <h6 class="my-0">
                        <a href="{{route('order.regular')}}"﻿​>
                            批量下單
                        </a>
                    </h6>

                </div>

            </li>

        <li class="list-group-item d-flex justify-content-between lh-condensed">
            <div>
                <h6 class="my-0">
                    <a href="{{route('order.select_deli')}}" target="_blank" ﻿​>
                        查詢送貨單
                    </a>
                </h6>

            </div>

        </li>
    @endcan

    {{--                        @foreach($dept_names as $key => $dept_name)--}}
    {{--                            <li class="list-group-item d-flex justify-content-between lh-condensed">--}}
    {{--                                <div>--}}
    {{--                                    <h6 class="my-0">--}}
    {{--                                        <a href="{{route('notice',['dept' => $key])}}">{{$dept_name}}</a>--}}
    {{--                                    </h6>--}}
    {{--                                </div>--}}

    {{--                            </li>--}}
    {{--                        @endforeach--}}

</ul>

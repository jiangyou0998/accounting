@extends('layouts.app')

@section('title')
    維修項目-已完成處理
@stop

@section('style')
    <style type="text/css">

        input[type="checkbox"] {
            width: 30px; /*Desired width*/
            height: 30px; /*Desired height*/
        }

        .checkbox {
            font-size: 30px;
            margin-bottom: 10px;
        }

        .container {
            margin-right: auto;
            margin-left: auto;
            padding-right: 15px;
            padding-left: 15px;
            width: 100%;
            max-width: 2000px;
        / / 隨螢幕尺寸而變，當螢幕尺寸 ≥ 1200 px 時是 1140 px。
        }

    </style>
@endsection

@section('content')

    <div class="container">
        <div class="py-5 text-center">
            <h2>維修項目</h2>
            <h2>已完成處理</h2>
        </div>

        @foreach($orders as $user_id => $shop_orders)
            <h2 class="text-center">{{ $users[$user_id] ?? '' }}</h2>
            @foreach($shop_orders as $order)
                <div>
                    <hr>
                    <h2 class="text-center">{{$order->order_no}}</h2>
                    <div class="card">

                        <div class="card-body">
                            <h4 class="card-title">完成日期 : {{$order->complete_date}}</h4>

                            @foreach($order->repair_projects as $value)
                                <p class="card-text">{{$loop->iteration}} . {{$value->locations->name}}
                                    - {{$value->items->name}} - {{$value->details->name}}</p>
                                <p class="card-text">跟進結果 : {{$value->comment}}</p>
                                <p class="card-text">維修費用 : ${{$value->fee}}</p>

                                @if($value->status === 99)
                                    <p class="card-text">已完成</p>
                                @elseif($value->status === 11)
                                    <p class="card-text text-red">需跟進</p>
                                @endif

                            @endforeach
{{--                            <a href="#" class="card-link">Card link</a>--}}
{{--                            <a href="#" class="card-link">Another link</a>--}}
                        </div>
                    </div>
                </div>

            @endforeach
        @endforeach

        <br>
        <br>
        <br>
        <br>
        <br>
    </div>

@endsection

{{--@section('script')--}}
{{--    <script>--}}
{{--        $(document).on('click', '.repair-order', function () {--}}
{{--            let shop_id = $(this).val();--}}
{{--            let name = 'repair-group-' + shop_id;--}}

{{--            let order_ids = $('input[type=checkbox][name="' + name + '"]:checked').map(function () {--}}
{{--                return this.value--}}
{{--            }).get().join(',');--}}

{{--            let url = '/repair_order?shop_id=' + shop_id + '&order_ids=' + order_ids;--}}

{{--            window.open(url);--}}
{{--            // console.log(url);--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}

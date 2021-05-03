@extends('layouts.app')

@section('title')
    範本
@stop

@section('content')

    <style type="text/css">
        <!--
        body {
            background-color: #FFFFCC;
        }

        .style4 {
            color: #FF0000;
            font-size: 50px;
        }

        .style5 {
            font-size: medium;
            font-weight: bold;
        }

        .sizefont {
            font-size: 130%;
        }

        -->
    </style>

    <div align="left"><a target="_top" href="{{route('order')}}" style="font-size: xx-large;">返回</a></div>

    <select class="custom-select w-25" id="shop" required>
        <option value="0">請選擇分店</option>
        @foreach($shops as $shop)
            <option value="{{$shop->id}}"
            @if(request()->input('shopid') == $shop->id) selected @endif
            >{{$shop->report_name}}</option>
        @endforeach
    </select>

    <div class="style5" style="text-align: center;">
        <span class="style4">創建外客範本</span>

    </div>

{{--    --}}
    <table width="100%" border="1" align="center" cellpadding="3" cellspacing="0">
        <div class="style5" style="text-align: center;">
            @foreach($shops as $shop)
                @if(request()->input('shopid') == $shop->id)
                    <span class="style4">{{$shop->report_name}}</span>
                @endif

            @endforeach
        </div>
        @if(request()->input('shopid'))
            <div style="margin-bottom: 10px;">
                <button class="sizefont"><a class="btn btn-primary" href="{!! route('sample.create',['dept'=>'CU','shopid'=>request()->input('shopid')])!!}">新建範本</a></button>
            </div>
        @endif

        @foreach($samples as $sample)
            @if($sample->dept == 'CU')
                <tr style="margin-top: 60px" class="sizefont">
                    <td align="right" width="4%"><strong>#</strong></td>

                    <td align="left"><a
                            href="{{route('sample.edit',$sample->id)}}"><strong>{{$sample->sampledate}}</strong></a>
                    </td>
                    <td align="middle" width="10%"><strong>
                            <button onclick="delsample({{$sample->id}});">刪除範本</button>
                        </strong></td>
                </tr>
            @endif
        @endforeach

@endsection

@section('js')
    <script type="text/javascript">

        function delsample(id) {

            Swal.fire({
                title: "您確定要刪除該範本嗎?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '刪除',
                cancelButtonText: '取消'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "/sample/" + id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (msg) {
                            Swal.fire({
                                title: "範本刪除成功!",
                                icon: 'success',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: '確定'
                            }).then((result) => {
                                window.location.reload();
                            })

                            // top.location.href = 'order_sample.php';
                        },
                        error: function (msg) {
                            // console.log(msg);
                            Swal.fire({
                                icon: 'error',
                                title: "刪除失敗!",
                            });

                        }
                    });

                }
            })

        }

        $(document).on('change', '#shop', function () {
            var shopid = $(this).val()
            if(shopid != 0){
                window.location.href = "{{route('customer.sample.index')}}?shopid="+shopid;
            }

        });

    </script>
@endsection

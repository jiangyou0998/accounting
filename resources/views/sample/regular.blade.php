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
            <option value="{{$shop->id}}">{{$shop->report_name}}</option>
        @endforeach
    </select>

    <div class="style5" style="text-align: center;">
        <span class="style4">創建範本</span>
    </div>

{{--    方包--}}
    <table width="100%" border="1" align="center" cellpadding="3" cellspacing="0">
        <div class="style5" style="text-align: center;">
            <span class="style4">第一車</span>
        </div>
        <div style="margin-bottom: 10px;">
            <button class="sizefont"><a class="btn btn-primary" href="{{route('sample.create',['dept'=>'D'])}}">新建方包範本</a></button>
        </div>
        @foreach($samples as $sample)
            @if($sample->dept == 'D')
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

@section('script')
    <script>
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
    </script>
@endsection

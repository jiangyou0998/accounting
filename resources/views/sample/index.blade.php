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
    <div class="style5" style="text-align: center;">
        <span class="style4">創建範本</span>
    </div>

    <div align="center">
        <strong>
            <span style="color: #FF0000; font-size: 144%; ">設定範本後，需到下單頁面點擊「落貨」按鈕，訂單才會正式提交。</span>
            <span style="color: #FF0000; font-size: 144%; "><br>請注意，如只設定範本而沒有到下單頁面提交訂單，當天分店將不會收到任何貨品。</span>
        </strong>
    </div>

{{--    烘焙--}}
    <table width="100%" border="1" align="center" cellpadding="3" cellspacing="0">
        <div class="style5" style="text-align: center;">
            <span class="style4">烘焙</span>
        </div>
        <div style="margin-bottom: 10px;">
            <button class="sizefont"><a class="btn btn-primary" href="{{route('sample.create',['dept'=>'R'])}}">新建烘焙範本</a></button>
        </div>
        @foreach($samples as $sample)
            @if($sample->dept == 'R')
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

    </table>
    <br>

{{--    第二車--}}
    <table width="100%" border="1" align="center" cellpadding="3" cellspacing="0">
        <div class="style5" style="text-align: center;">
            <span class="style4">第二車</span>
        </div>
        <div style="margin-bottom: 10px;">
            <button class="sizefont"><a class="btn btn-primary" href="{{route('sample.create',['dept'=>'R2'])}}">新建第二車範本</a></button>
        </div>
        @foreach($samples as $sample)
            @if($sample->dept == 'R2')
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


    </table>

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
                            // console.log(msg);
                            // Swal.fire({
                            //     icon: 'success',
                            //     title: "範本刪除成功!",
                            // });

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

            // var confirmBox = confirm('您確定要刪除該範本嗎?');
            //
            // if(confirmBox == true){
            //     // alert(id);
            //     $.ajax({
            //         type: "DELETE",
            //         url: "/sample/"+id,
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         },
            //         success: function (msg) {
            //             // console.log(msg);
            //             alert('範本刪除成功!');
            //             window.location.reload('order_sample.php');
            //             // top.location.href = 'order_sample.php';
            //         }
            //     });
            // }

        }
    </script>





@endsection

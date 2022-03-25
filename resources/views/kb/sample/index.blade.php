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

{{--    循環加載範本--}}
    @foreach($all_samples as $samples)
        @include('kb.sample._sample_list')
    @endforeach

    <script>
        //「刪除範本」按鈕
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
                        url: "/kb/sample/" + id,
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

                        },
                        error: function (msg) {

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

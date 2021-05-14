@extends('layouts.app')

@section('title')
    庫存
@stop

@section('content')

    <div class="container">
        <div class="py-5 text-center">

            <h2>庫存-{{\Carbon\Carbon::now()->subMonth()->monthName}}</h2>
        </div>
        <div class="row">
            @foreach($groups as $key => $value)
                @include('stock._table')
            @endforeach
        </div>
    </div>

@endsection

@section('script')
    <script>
        //确定离开当前页面
        // window.onbeforeunload = function (e) {
        //     var e = window.event || e;
        //     e.returnValue = ("确定离开当前页面吗？");
        // }

        $('.qty').blur(function () {

            let qty = $(this).val();

            if(isNaN(qty)){
                return ;
            }

            if (qty == null || qty == undefined || qty == "") {
                return ;
            }

            if(qty <= 0){
                Swal.fire({
                    icon: 'error',
                    title: "請輸入大於0的數字",
                });
                return ;
            }

            $.ajax({
                type: "POST",
                url: "{{ route('stock.add') }}",
                data: {
                    'product_id': $(this).data('id'),
                    'qty': qty
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (msg) {
                    // window.location.reload();
                },
                error:function () {
                    Swal.fire({
                        icon: 'error',
                        title: "系统错误",
                    });
                }
            });

        });
    </script>
@endsection


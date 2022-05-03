@extends('layouts.app')

@section('title')
    庫存
@stop

@section('style')
    <style type="text/css">

        /*.main-div{*/
        /*    display: flex;*/
        /*    width: 100%;*/
        /*}*/

        .left-div{
            width: 50%;
            height: 60vh;
            overflow: auto;

        }

        .right-div{
            width: 40%;
            height: 60vh;
            overflow-x: hidden;
            overflow-y: auto;

        }


    </style>
@endsection


@section('content')

    <div class="container">

{{--        標題--}}
        <div class="py-4 text-center">

            <h2>請選擇入庫日期</h2>
        </div>

        <div class="py-4 text-center">

            <input type="date" name="date" id="date" value="{{\Carbon\Carbon::now()->toDateString()}}">
            <button type="submit" class="btn btn-primary" id="sumbit">查詢</button>
        </div>
{{--        頂部按鈕--}}
  </div>
@endsection

@section('script')
    <script>

        $(document).on('click', '#sumbit', function () {
            let date = $("#date").val();

            if (date === null || date === '') {
                Swal.fire({
                    icon: 'warning',
                    title: "請選擇時間",
                });
                return false;
            }

            let url = '{{ route('stock.warehouse.index' )}}' + '?date=' + date;

            window.open(url);

        });

    </script>

@endsection


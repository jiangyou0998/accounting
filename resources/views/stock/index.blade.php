@extends('layouts.app')

@section('title')
    庫存
@stop

@section('content')

    <div class="container">
        <div class="py-5 text-center">

            <h2>庫存</h2>
        </div>
        <div class="row">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">編號</th>
                    <th scope="col">貨名</th>
                    <th scope="col">結存</th>
                    <th scope="col">包裝</th>
                </tr>
                </thead>
                <tbody class="table-striped" style="background-color: white">
                    @foreach($items as $item)
                        <tr>
                            <td>{{$item->products->product_no}}</td>
                            <td>{{$item->products->product_name}}</td>
                            <td><input type="text" name="" id=""></td>
                            <td>{{$item->unit->unit_name}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

@endsection

@section('script')
    <script>
        //确定离开当前页面
        window.onbeforeunload = function (e) {
            var e = window.event || e;
            e.returnValue = ("确定离开当前页面吗？");
        }
    </script>
@endsection


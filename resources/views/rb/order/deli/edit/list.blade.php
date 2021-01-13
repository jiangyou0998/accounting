@extends('layouts.app')

@section('title')
    改舊單
@stop

@section('css')
    <link href="/js/My97DatePicker/skin/WdatePicker.css" rel="stylesheet" type="text/css">
@endsection

@section('style')
    <style type="text/css">
        body {
            margin-left: 40px;
        }

        a:link {
            color: #0000FF;
        }

        a:visited {
            color: #0000FF;
        }

        a:hover {
            color: #FF00FF;
        }

        a:active {
            color: #0000FF;
        }

    </style>
@endsection

@section('content')
    <div align="left"><a target="_top" href="{{route('order')}}" style="font-size: xx-large;">返回</a></div>
    <div class="form-inline" style="margin-bottom: 10px;">
        <input type="text" name="delidate" class="form-control" value="{{$infos->deli_date}}" id="datepicker"
               onclick="WdatePicker({maxDate:'',isShowClear:false})" style="width:125px" readonly>

        <button class="btn btn-default" onclick="btnSubmit();">查詢</button>

    </div>



    <div align="center" style="width:995px; padding:0px 8px;">

        <table class="table table-striped" width="100%" border="1" cellspacing="0" cellpadding="8" style="padding:8px;">
            <tbody>
            <tr>

                <td align="center" bgcolor="#CCCCCC"><strong>收貨日期</strong></td>
                <td align="center" bgcolor="#CCCCCC"><strong>分店</strong></td>
                <td align="center" bgcolor="#CCCCCC"><strong>總數($)</strong></td>

            </tr>

            @foreach($lists as $list)
                <tr>
                    <td align="center">
                        <a href="{{route('order.deli.edit',['shop'=>$list->user_id,'deli_date'=>$list->deli_date])}}"
                           target='view_window'>
                            {{$list->deli_date}}
                        </a>
                    </td>
                    <td align="center">
                        <span>{{$list->report_name}}</span>
                    </td>

                    <td align="right">{{number_format($list->po_total,2)}}</td>

                </tr>
            @endforeach

            </tbody>
        </table>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        function btnSubmit(){
            window.location.href = "{{route('order.deli.list')}}?deli_date="+$('#datepicker').val();
        }
    </script>
@endsection

@section('js')
    <script src="/js/My97DatePicker/WdatePicker.js"></script>
@endsection







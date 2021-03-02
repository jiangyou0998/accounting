<html>
<head>
    <meta name="ROBOTS" content="NOINDEX,NOFOLLOW">
        <meta name="format-detection" content="telephone=no" />
        <title>送貨表-內聯網</title>
        <link href="/js/My97DatePicker/skin/WdatePicker.css" rel="stylesheet" type="text/css">
        <script src="/js/jquery.min.js"></script>
        <script src="/js/My97DatePicker/WdatePicker.js"></script>
        <script src="/js/parser.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">

        <style>
            <!--
            .style1 {
                font-size: 34px
            }

            .style3 {
                font-size: 16px;
            }

            .style6 {
                font-size: 22px;
                font-weight: bold;
            }

            body {
                width: 21cm;
                height: 29.7cm;
                margin-left: auto;
                margin-right: auto;
                padding: 0px;
            }

            #content td {
                padding: 4px;
            }

            -->
        </style>
        </head>
<body>
<div class="form-inline" style="margin-top: 10px;margin-bottom: 10px;">

        <table width="100%" border="0" cellspacing="0" cellpadding="0" >
            <tr>
                <td valign="middle" style=" white-space:nowrap">
                    <input type="text" name="checkDate" class="form-control" value="{{ $infos->deli_date }}" id="datepicker"
                           onclick="WdatePicker({maxDate:'',isShowClear:false})" style="width:125px" readonly>

{{--                    <input type="submit" name="Submit" value="查詢"/>--}}
                    <button class="btn btn-default" onclick="select()">查詢</button>
                </td>
                <td style="text-align: right">生成時間 : {{$infos->now}}</td>
            </tr>

        </table>



</div>
<div>
    <img src="/images/invoice_top.jpeg" alt="Top Header" style="width:100%; border:0px solid black;" border="0">
</div>
<br>
<table style="width:100%">
    <tr>
        <td style="width:33%">&nbsp;</td>
        <td style="width:33%" align="center">分店:　{{ $infos->shop_name }}</td>
        <td style="width:33%" align="right">日期:　{{ $infos->deli_date }}</td>
    </tr>
</table>
<br/>
<table id="content" style="width:100%" cellspacing="0" cellpadding="0" border="2">

    @foreach($totals as $total)
        {{--          表頭  --}}
        @include('order.deli._table_head')
        {{--        具體內容--}}
        @include('order.deli._table_data')
        {{--        合計--}}
        @include('order.deli._total')
    @endforeach



</table>

</body>

<script>
    function select() {
        var deli_date = $('#datepicker').val();
        window.location.href = '/order/deli?deli_date='+deli_date+'&shop={{$infos->shop}}';
    }
</script>

</html>

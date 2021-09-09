<html>
<head>
    <meta name="ROBOTS" content="NOINDEX,NOFOLLOW">
        <meta name="format-detection" content="telephone=no" />
        <title>送貨表-內聯網</title>
        <script src="/js/jquery.min.js"></script>
        <script src="/js/parser.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">

        <style>

            body {
                width: 21cm;
                height: 29.7cm;
                margin-left: auto;
                margin-right: auto;
                padding: 0px;
            }

            #content td {
                padding: 3px;
                font-weight : 600;
            }

            th {
                font-weight:bold;
                padding-bottom: 5px;
                font-size: large;
            }

            .parent{display:flex}
            .left{width:45%}
            .left div{text-align: left;}
            .left span{font-weight: bold;}
            .right span{font-weight: bold;}

            .footer {
                page-break-after:always;
                bottom : 0;
            }

        </style>
        </head>
<body>
@foreach($allData as $datas)
    @if($datas['infos']->total > 0)
        <div class="form-inline" style="margin-top: 10px;margin-bottom: 10px;">

        </div>
        <div>
            <img src="/images/invoice_top.jpeg" alt="Top Header" style="width:100%; border:0px solid black;" border="0">
        </div>
        <br>
        <h3 style="text-align: center;padding-bottom: 6px;"><u>STATEMENT</u></h3>
        {{--            2021-09-09 新增列印時間顯示--}}
        <tr>
            <div align="right" style="font-weight: bold;">
                <span>Print Time：{{ \Carbon\Carbon::now()->toDateTimeString() }}</span>
            </div>
        </tr>
        <table style="width:100%">
            <td style="width:70%" align="left">
                <div><span><b>{{ $datas['infos']->shop_name }}</b></span></div>
                <div><span><b>{{ $datas['infos']->company_name }}</b></span></div>
                <div><span>{{ $datas['infos']->address }}</span></div>
                <div><span>Phone&nbsp;:&nbsp;{{ $datas['infos']->phone }}</span></div>
                <div><span>Fax&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;{{ $datas['infos']->fax }}</span></div>
            </td>
            <td style="width:30%" align="left">

                <div class='parent'>
                    <div class="left">
                        <div>
                            <span>Date</span>
                        </div>
                        <div>
                            <span>From Date</span>
                        </div>
                        <div>
                            <span>To Date</span>
                        </div>
                    </div>
                    <div class="right">
                        <div>
                            <span>：{{ $datas['infos']->deli_date }}</span>
                        </div>
                        <div>
                            <span>：{{ $datas['infos']->start_date }}</span>
                        </div>
                        <div>
                            <span>：{{ $datas['infos']->end_date }}</span>
                        </div>
                    </div>
                </div>

            </td>

        </table>
        <br/>
        <table id="content" border="0" style="width:100%" cellspacing="0" cellpadding="0" border="2">

            {{--          表頭  --}}
            @include('admin.statement._table_head')
            {{--        具體內容--}}
            @include('admin.statement._table_data')


        </table>
        {{--        合計--}}
        @include('admin.statement._total')
        {{--    footer--}}
        @include('admin.statement._footer')
    @endif
@endforeach
</body>
</html>

<html>
<head>
    <meta name="ROBOTS" content="NOINDEX,NOFOLLOW">
    <meta name="format-detection" content="telephone=no"/>
    <title>Invoice-內聯網</title>
    <script src="/js/jquery.min.js"></script>
    <script src="/js/parser.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css"
          integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    <style>

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

        #content th {
            padding: 4px;
        }

        .parent{display:flex}
        .left{width:35%}
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

{{--初始化頁碼--}}
@foreach($allData as $shop_datas)

@foreach($shop_datas as $data)
    @php
        $page = 0;
    @endphp
@foreach($data['details'] as $detail)
    {{--    每13個一頁,生成表頭和頂部--}}
    @if(($loop->index % $data['infos']->item_count) == 0)

        <div>
            <img src="/images/invoice_top.jpeg" alt="Top Header" style="width:100%; border:0px solid black;" border="0">
        </div>

        <br>
        <table style="width:100%">
            <h3 style="text-align: center;padding-bottom: 6px;">
                <u>
                    @if(request()->type == 'CUR')
                        RETURN INVOICE : {{ $data['infos']->pocode }}R
                    @else
                        INVOICE : {{ $data['infos']->pocode }}
                    @endif
                </u>
            </h3>

{{--            2021-09-09 新增列印時間顯示--}}
            <tr>
                <div align="right" style="font-weight: bold;">
                    <span>Print Time：{{ \Carbon\Carbon::now()->toDateTimeString() }}</span>
                </div>
            </tr>

            <tr>
                {{--                <td style="width:33%"></td>--}}
                <td style="width:70%" align="left">
                    @if($data['infos']->shop_name)
                        <div><span><b>{{ $data['infos']->shop_name }}</b></span></div>
                    @endif

                    @if($data['infos']->company_name)
                        <div><span><b>{{ $data['infos']->company_name }}</b></span></div>
                    @endif

                    @if($data['infos']->address)
                        <div><span>{{ $data['infos']->address }}</span></div>
                    @endif

                    @if($data['infos']->phone)
                        <div><span>Phone&nbsp;:&nbsp;{{ $data['infos']->phone }}</span></div>
                    @endif

                    @if($data['infos']->fax)
                        <div><span>Fax&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;{{ $data['infos']->fax }}</span></div>
                    @endif
                </td>
                <td style="width:30%" align="left">
                    <div class='parent'>
                        <div class="left">
                            <div>
                                <span>Page No.</span>
                            </div>
                            <div>
                                <span>Date</span>
                            </div>
                            @if($data['infos']->customer_po)
                                <div>
                                    <span>PO</span>
                                </div>
                            @endif

{{--                            修改過的訂單顯示「REVISED」--}}
                            @if($data['infos']->revised)
                                <div>
                                    <span style="font-size: x-large">REVISED</span>
                                </div>
                            @endif

                        </div>
                        <div class="right">
                            <div>
                                <span>：{{++$page}}</span>
                            </div>
                            <div>
                                <span>：{{ $data['infos']->deli_date }}</span>
                            </div>
                            @if($data['infos']->customer_po)
                                <div>
                                    <span>：{{ $data['infos']->customer_po }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                </td>
            </tr>
        </table>
        <br/>

        <table id="content" style="width:100%" cellspacing="0" cellpadding="0">
            {{--    打印時每頁都有的表頭--}}
            @include('admin.invoice._table_head')
    @endif
            {{--    加載數據--}}
            @include('admin.invoice._table_data')

            {{--    第14個,生成打印分頁div--}}
            @if(($loop->index % $data['infos']->item_count) == ( $data['infos']->item_count - 1 ) || $loop->last)
        </table>
                @if($loop->last)
                    @include('admin.invoice._total')
                    <hr style="border-top:2px solid black;">
                    <footer class="footer">
                        <img src="/images/invoice_signature_kb.jpeg" alt="Footer" style="width:100%; border:0px solid black;" border="0">
                    </footer>
                @else
                    <footer></footer>
                @endif

            @endif

        @endforeach
        {{--    @endforeach--}}

        </table>
@endforeach
@endforeach
</body>

</html>

<html>
<head>
    <meta name="ROBOTS" content="NOINDEX,NOFOLLOW">
    <meta name="format-detection" content="telephone=no"/>
    <title>送貨表-內聯網</title>
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
@php
    $page = 0;
@endphp
@foreach($details as $detail)
    {{--    每13個一頁,生成表頭和頂部--}}
    @if(($loop->index % $infos->item_count) == 0)

        <div>
            <img src="/images/invoice_top.jpeg" alt="Top Header" style="width:100%; border:0px solid black;" border="0">
        </div>

        <br>
        <table style="width:100%">
            <h3 style="text-align: center;padding-bottom: 6px;"><u>INVOICE : {{ $infos->pocode }}</u></h3>
            <tr>
                {{--                <td style="width:33%"></td>--}}
                <td style="width:70%" align="left">
                    @isset($infos->company_name)
                        <div><span><b>{{ $infos->company_name }}</b></span></div>
                    @endisset

                    @isset($infos->address)
                        <div><span>{{ $infos->address }}</span></div>
                    @endisset

                    @isset($infos->phone)
                        <div><span>Phone&nbsp;:&nbsp;{{ $infos->phone }}</span></div>
                    @endisset

                    @isset($infos->fax)
                        <div><span>Fax&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;{{ $infos->fax }}</span></div>
                    @endisset
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
                        </div>
                        <div class="right">
                            <div>
                                <span>：{{++$page}}</span>
                            </div>
                            <div>
                                <span>：{{ $infos->deli_date }}</span>
                            </div>
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
            @if(($loop->index % $infos->item_count) == ( $infos->item_count - 1 ) || $loop->last)
        </table>
                @if($loop->last)
                    @include('admin.invoice._total')
                    <hr style="border-top:2px solid black;">
                    <footer class="footer">
{{--                        <div>--}}
{{--                            <div><span><b><i>For and on behalf of</i></b></span></div>--}}
{{--                            <div><span><b>糧友麵包飲食有限公司</b></span></div>--}}
{{--                            <div style="width: 30%">--}}
{{--                                <img src="/images/invoice_signature_rb.jpeg" alt="Footer" style="width:100%; border-bottom:1px solid black;" border="0">--}}
{{--                            </div>--}}
{{--                            <div><span><b><i>Authorized signature</i></b></span></div>--}}
{{--                            <div style="font-size: large;text-align: center; padding-top: 6px">--}}
{{--                                <b>付款方式：請開支票抬頭人"Ryoyupan Bakery Catering Limited"</b>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <img src="/images/invoice_signature_rb2.jpeg" alt="Footer" style="width:100%; border-bottom:1px solid black;" border="0">
                    </footer>
                @else
                    <footer></footer>
                @endif

            @endif

        @endforeach
        {{--    @endforeach--}}

        </table>

</body>

</html>

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

        .content td {
            padding: 4px;
        }

        .footer {
            /*position: absolute;*/
            /*bottom: 0;*/
            /*width: 100% ;*/
            /*!* Set the fixed height of the footer here *!*/
            /*height: 60px;*/
            /*background-color: #000;*/

        }

        /*thead #pagecode:after {*/
        /*    counter-increment: page;*/
        /*    content: "Page " counter(page);*/
        /*}*/

        #pagecode:after
        {
            counter-increment: page;
            content: "Page " counter(page);
        }

        /*@page {*/
        /*    counter-increment: page;*/
        /*    counter-reset: page 1;*/
        /*    @top-right {*/
        /*        content: "Page " counter(page) " of " counter(pages);*/
        /*    }*/
        /*}*/

    </style>
</head>
<body>

{{--初始化頁碼--}}
@php
    $page = 0;
@endphp

<table class="content" style="width:100%" cellspacing="0" cellpadding="0">
    <THEAD style="display:table-header-group;font-weight:bold">
    <TR>
        <td colspan="6">
            <div>
                <img src="/images/invoice_top.jpeg" alt="Top Header" style="width:100%; border:0px solid black;" border="0">
            </div>

            <br>
            <table style="width:100%">
                <h3 style="text-align: center"><u>INVOICE:</u></h3>
                <tr>
                    {{--                <td style="width:33%"></td>--}}
                    <td style="width:70%" align="left">
                        <div><span>{{ $infos->company_name }}</span></div>
                        <div><span>{{ $infos->address }}</span></div>
                        <div><span>Phone:{{ $infos->phone }}</span></div>
                        <div><span>Fax:{{ $infos->fax }}</span></div>
                    </td>
                    <td style="width:30%" align="left">

                        <div><span style="width:100px">Date</span>:　{{ $infos->deli_date }}</div>

                    </td>
                </tr>

            </table>
            <br/>
        </td>

    </TR>
    @include('admin.invoice._table_head')
    <div><span style="width:100px">Page No.</span> : <span id="pagecode"></span></div>
    </THEAD>




            {{--    打印時每頁都有的表頭--}}

{{--    <table class="content" style="width:100%" cellspacing="0" cellpadding="0">--}}
        <tbody>
{{--    <table>--}}
{{--<table class="content" style="width:100%" cellspacing="0" cellpadding="0">--}}
{{--        @foreach($details as $detail)--}}
{{--            --}}
{{--        @endforeach--}}

@include('admin.invoice._table_data2')
{{--</table>--}}
        </tbody>


{{--    </table>--}}
            {{--    加載數據--}}


            {{--    第14個,生成打印分頁div--}}


        </table>


{{--        <div style="page-break-after:always;"></div>--}}





@include('admin.invoice._total')

        {{--    @endforeach--}}



        </table>

<footer class="footer">
    <img src="/images/invoice_signature_kb.jpeg" alt="Top Header" style="width:100%; border:0px solid black;" border="0">
</footer>

</body>

</html>

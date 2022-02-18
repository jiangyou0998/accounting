<html>
<head>
    <META name="ROBOTS" content="NOINDEX,NOFOLLOW">
        <title>內聯網</title>


        <style>
            <!--
            .style1 {
                font-size: 34px
            }

            .style3 {
                font-size: 16px;
            }

            .style6 {
                font-size: 21px;
                /*font-weight: bold;*/
            }

            .data {
                max-height: 30px;
                height: 30px;
                min-height: 30px;
                vertical-align: middle;
                padding: 2px;
                padding-left: 4px;
            }

            body {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
                background-color: #FAFAFA;
            }

            * {
                box-sizing: border-box;
                -moz-box-sizing: border-box;
            }

            .page {
                width: 203mm;
                min-height: 293mm;
                padding: 4mm;
                background: white;
            }

            .box {
                width: 100%;
                /* 因为 content 会另起一行，影响样式的话，height 设置为具体的值可以避免高度变高的情况 */
                /* 设置元素两端对齐 */
                text-align: justify;
            }

            /* 这里的伪元素一定要加上，不然span元素不能两端对齐 */
            .box:after {
                content: "";
                display: inline-block;
                overflow: hidden;
                width: 100%;
            }

            /*.box span {*/
            /*    height: 50px;*/
            /*    !* 设置盒子为行内块 *!*/
            /*    display: inline-block;*/
            /*    !* 设置盒子内元素水平居中 *!*/
            /*    text-align: center;*/
            /*    !* 设置盒子内容垂直居中 *!*/
            /*    line-height: 50px;*/
            /*}*/

            .header-title{
                font-size: 22px;
                font-weight: bold;
            }

            .footer-sign{
                font-size: 20px;
            }

            -->
        </style>

<body>


<div class="page">
    <div width="100%">


        <div width="100%">
            <div width="50%" align="left">列印時間: {{\Carbon\Carbon::now()->toDateTimeString()}}</div>
            <div width="50%" align="right">(存票 NO. {{ $print_info->deposit_no }})</div>
        </div>

        <br/>

        <table class="header-title" border="0" cellpadding="0" cellspacing="0" width="100%">
            <th align="left" style="width:33%"><strong></strong></th>
            <th align="center" style="width:33%"><strong>分店名稱&nbsp;：&nbsp;{{ $print_info->shop_name }}</strong></th>
            <th align="right" style="width:33%"><strong>{{ $print_info->date }}</strong></th>
        </table>

        <hr/>

        <table border="1" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <th align="center" style="width:15%; height:30px;"><strong>承上結存</strong></th>
                <th align="center" style="width:43%"><strong>摘要</strong></th>
                <th align="center" style="width:14%"><strong>收入</strong></th>
                <th align="center" style="width:14%"><strong>支出</strong></th>
                <th align="center" style="width:14%"><strong>餘額</strong></th>

            </tr>

            @foreach($sales_table_data as $row)
                <tr bgcolor="#FFFFFF">
                @foreach($row as $value)
                    <td class="data style6">
                        {!! $value !!}
                    </td>
                @endforeach
                <tr>
            @endforeach

        </table>
        <table class="footer-sign" border="0" cellpadding="0" cellspacing="0" width="100%">
            <th align="left" style="width:33%"><strong>主管簽署:</strong></th>
            <th align="left" style="width:33%"><strong>主管簽署:</strong></th>
            <th align="left" style="width:33%"><strong>會計:</strong></th>
        </table>
    </div>
</div>

</body>

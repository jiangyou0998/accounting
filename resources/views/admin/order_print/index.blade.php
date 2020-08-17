
<html>
<head>
    <META name="ROBOTS" content="NOINDEX,NOFOLLOW">
        <title>內聯網</title>
        <link href="js/My97DatePicker/skin/WdatePicker.css" rel="stylesheet" type="text/css">
        <script src="js/jquery-1.9.1.min.js"></script>
        <script src="js/My97DatePicker/WdatePicker.js"></script>
        <script src="js/parser.js"></script>
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

            .data {
                max-height: 32px;
                height: 32px;
                min-height: 32px;
                vertical-align: middle;
                padding: 4px;
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
                width: 297mm;
                min-height: 203mm;
                padding: 4mm;
                background: white;
            }

            -->
        </style>

<body>

<div class="page">
    <div width="100%">



        <div width="100%">
            <div width="50%" align="left">列印時間: 2020-08-12 10:30</div>
            <div width="50%" align="right">1/2</div>
        </div>

        <br/>
        <span class="style1">麵包部 - 生包 - 麵粒、酥 </span>
        <span class="style1"
              style="margin-left:400px;">出貨日期：
                            1/8/2020 (六)
                        </span>
        <hr/>
        <table border="1" cellpadding="0" cellspacing="0">
            @include('admin.order_print._head')

                @foreach($datas as $data)

                    @include('admin.order_print._line')

                @endforeach



            <tr bgcolor="#EEEEEE">
                <td class="data style3" align="center">2</td>
                <td class="data style3" align="center">1000002</td>
                <td class="data style3" align="center"
                    style="max-width:130px; min-width:130px; width:130px;">甜麵粒</td>
                <td class="data style6" align="center" bgcolor="#FFFFCC">
                    3030                        </td>
                <td align="center" class="data style6"
                    width="">180</td>
                <td align="center" class="data style6"
                    width="">150</td>
                <td align="center" class="data style6"
                    width="">180</td>
                <td align="center" class="data style6"
                    width="">150</td>
                <td align="center" class="data style6"
                    width="">270</td>
                <td align="center" class="data style6"
                    width="">270</td>
                <td align="center" class="data style6"
                    width="">150</td>
                <td align="center" class="data style6"
                    width="">480</td>
                <td align="center" class="data style6"
                    width="">180</td>
                <td align="center" class="data style6"
                    width="">150</td>
            </tr>

            <tr bgcolor="#FFFFFF">
                <td class="data style3" align="center">3</td>
                <td class="data style3" align="center">1000003</td>
                <td class="data style3" align="center"
                    style="max-width:130px; min-width:130px; width:130px;">提子麥麵粒</td>
                <td class="data style6" align="center" bgcolor="#FFFFCC">
                    810                        </td>
                <td align="center" class="data style6"
                    width="">60</td>
                <td align="center" class="data style6"
                    width="">30</td>
                <td align="center" class="data style6"
                    width="">30</td>
                <td align="center" class="data style6"
                    width="">30</td>
                <td align="center" class="data style6"
                    width="">30</td>
                <td align="center" class="data style6"
                    width="">30</td>
                <td align="center" class="data style6"
                    width="">30</td>
                <td align="center" class="data style6"
                    width="">360</td>
                <td align="center" class="data style6"
                    width=""></td>
                <td align="center" class="data style6"
                    width="">30</td>
            </tr>

            <tr bgcolor="#EEEEEE">
                <td class="data style3" align="center">4</td>
                <td class="data style3" align="center">1004001</td>
                <td class="data style3" align="center"
                    style="max-width:130px; min-width:130px; width:130px;">丹麥條</td>
                <td class="data style6" align="center" bgcolor="#FFFFCC">
                    312                        </td>
                <td align="center" class="data style6"
                    width="">18</td>
                <td align="center" class="data style6"
                    width="">12</td>
                <td align="center" class="data style6"
                    width="">24</td>
                <td align="center" class="data style6"
                    width="">18</td>
                <td align="center" class="data style6"
                    width="">12</td>
                <td align="center" class="data style6"
                    width="">24</td>
                <td align="center" class="data style6"
                    width="">30</td>
                <td align="center" class="data style6"
                    width="">36</td>
                <td align="center" class="data style6"
                    width="">30</td>
                <td align="center" class="data style6"
                    width="">12</td>
            </tr>

            <tr bgcolor="#FFFFFF">
                <td class="data style3" align="center">5</td>
                <td class="data style3" align="center">1004002</td>
                <td class="data style3" align="center"
                    style="max-width:130px; min-width:130px; width:130px;">牛角酥</td>
                <td class="data style6" align="center" bgcolor="#FFFFCC">
                    0                        </td>
                <td align="center" class="data style6"
                    width=""></td>
                <td align="center" class="data style6"
                    width=""></td>
                <td align="center" class="data style6"
                    width=""></td>
                <td align="center" class="data style6"
                    width=""></td>
                <td align="center" class="data style6"
                    width=""></td>
                <td align="center" class="data style6"
                    width=""></td>
                <td align="center" class="data style6"
                    width=""></td>
                <td align="center" class="data style6"
                    width=""></td>
                <td align="center" class="data style6"
                    width=""></td>
                <td align="center" class="data style6"
                    width=""></td>
            </tr>

            <tr bgcolor="#EEEEEE">
                <td class="data style3" align="center">6</td>
                <td class="data style3" align="center">1000004</td>
                <td class="data style3" align="center"
                    style="max-width:130px; min-width:130px; width:130px;">牛油餐包麵</td>
                <td class="data style6" align="center" bgcolor="#FFFFCC">
                    600                        </td>
                <td align="center" class="data style6"
                    width="">80</td>
                <td align="center" class="data style6"
                    width=""></td>
                <td align="center" class="data style6"
                    width="">120</td>
                <td align="center" class="data style6"
                    width=""></td>
                <td align="center" class="data style6"
                    width="">30</td>
                <td align="center" class="data style6"
                    width="">30</td>
                <td align="center" class="data style6"
                    width="">20</td>
                <td align="center" class="data style6"
                    width="">120</td>
                <td align="center" class="data style6"
                    width="">30</td>
                <td align="center" class="data style6"
                    width="">30</td>
            </tr>
        </table>
        <div style="page-break-after:always;"></div>
    </div>

    <div class="page">
        <div width="100%">



            <div width="100%">
                <div width="50%" align="left">列印時間: 2020-08-12 10:30</div>
                <div width="50%" align="right">2/2</div>
            </div>

            <br/>
            <span class="style1">麵包部 - 生包 - 麵粒、酥 </span>
            <span class="style1"
                  style="margin-left:400px;">出貨日期：
                            1/8/2020 (六)
                        </span>
            <hr/>
            <table border="1" cellpadding="0" cellspacing="0">
                <tr bgcolor="#CCFFFF">
                    <td align="center" style="width:30px; height:40px;"><strong>#</strong></td>
                    <td align="center" style="width:90px"><strong>產品編號</strong></td>
                    <td align="center" style="max-width:130px; min-width:130px; width:130px;"><strong>產品名稱</strong></td>
                    <td bgcolor="#FFFFCC" align="center" style="width:85px"><strong>Total</strong></td>
                    <td align="center" style="width:85px"><strong>愛東</strong></td>
                    <td align="center" style="width:85px"><strong>泓景匯</strong></td>
                    <td align="center" style="width:85px"><strong>東南樓</strong></td>
                    <td align="center" style="width:85px"><strong>光華</strong></td>
                    <td align="center" style="width:85px"><strong>長發</strong></td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td class="data style3" align="center">1</td>
                    <td class="data style3" align="center">1000001</td>
                    <td class="data style3" align="center"
                        style="max-width:130px; min-width:130px; width:130px;">咸麵粒</td>
                    <td class="data style6" align="center" bgcolor="#FFFFCC">
                        45                        </td>
                    <td align="center" class="data style6"
                        width="">9</td>
                    <td align="center" class="data style6"
                        width=""></td>
                    <td align="center" class="data style6"
                        width="">9</td>
                    <td align="center" class="data style6"
                        width="">9</td>
                    <td align="center" class="data style6"
                        width=""></td>
                </tr>

                <tr bgcolor="#EEEEEE">
                    <td class="data style3" align="center">2</td>
                    <td class="data style3" align="center">1000002</td>
                    <td class="data style3" align="center"
                        style="max-width:130px; min-width:130px; width:130px;">甜麵粒</td>
                    <td class="data style6" align="center" bgcolor="#FFFFCC">
                        3030                        </td>
                    <td align="center" class="data style6"
                        width="">150</td>
                    <td align="center" class="data style6"
                        width="">180</td>
                    <td align="center" class="data style6"
                        width="">180</td>
                    <td align="center" class="data style6"
                        width="">180</td>
                    <td align="center" class="data style6"
                        width="">180</td>
                </tr>

                <tr bgcolor="#FFFFFF">
                    <td class="data style3" align="center">3</td>
                    <td class="data style3" align="center">1000003</td>
                    <td class="data style3" align="center"
                        style="max-width:130px; min-width:130px; width:130px;">提子麥麵粒</td>
                    <td class="data style6" align="center" bgcolor="#FFFFCC">
                        810                        </td>
                    <td align="center" class="data style6"
                        width="">30</td>
                    <td align="center" class="data style6"
                        width="">30</td>
                    <td align="center" class="data style6"
                        width="">60</td>
                    <td align="center" class="data style6"
                        width="">30</td>
                    <td align="center" class="data style6"
                        width="">30</td>
                </tr>

                <tr bgcolor="#EEEEEE">
                    <td class="data style3" align="center">4</td>
                    <td class="data style3" align="center">1004001</td>
                    <td class="data style3" align="center"
                        style="max-width:130px; min-width:130px; width:130px;">丹麥條</td>
                    <td class="data style6" align="center" bgcolor="#FFFFCC">
                        312                        </td>
                    <td align="center" class="data style6"
                        width="">12</td>
                    <td align="center" class="data style6"
                        width="">24</td>
                    <td align="center" class="data style6"
                        width="">24</td>
                    <td align="center" class="data style6"
                        width="">18</td>
                    <td align="center" class="data style6"
                        width="">18</td>
                </tr>

                <tr bgcolor="#FFFFFF">
                    <td class="data style3" align="center">5</td>
                    <td class="data style3" align="center">1004002</td>
                    <td class="data style3" align="center"
                        style="max-width:130px; min-width:130px; width:130px;">牛角酥</td>
                    <td class="data style6" align="center" bgcolor="#FFFFCC">
                        0                        </td>
                    <td align="center" class="data style6"
                        width=""></td>
                    <td align="center" class="data style6"
                        width=""></td>
                    <td align="center" class="data style6"
                        width=""></td>
                    <td align="center" class="data style6"
                        width=""></td>
                    <td align="center" class="data style6"
                        width=""></td>
                </tr>

                <tr bgcolor="#EEEEEE">
                    <td class="data style3" align="center">6</td>
                    <td class="data style3" align="center">1000004</td>
                    <td class="data style3" align="center"
                        style="max-width:130px; min-width:130px; width:130px;">牛油餐包麵</td>
                    <td class="data style6" align="center" bgcolor="#FFFFCC">
                        600                        </td>
                    <td align="center" class="data style6"
                        width=""></td>
                    <td align="center" class="data style6"
                        width="">30</td>
                    <td align="center" class="data style6"
                        width="">20</td>
                    <td align="center" class="data style6"
                        width="">60</td>
                    <td align="center" class="data style6"
                        width="">30</td>
                </tr>
            </table>
            <div style="page-break-after:always;"></div>
        </div>
</body>

<html>
<head>
    <title>內聯網</title>
    <meta name="ROBOTS" content="NOINDEX,NOFOLLOW">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/checkbox-style.css"/>
{{--    <link rel="stylesheet" type="text/css" href="/js/layui/css/layui.css">--}}

    <!-- Bootstrap CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css"
          id="theme-styles">

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function () {
            $(".dept-input").click(function () {

                var u = navigator.userAgent;
                if (u.indexOf('iPhone') > -1 || u.indexOf('iPad') > -1) {
                    // ios端的方法
                    this.selectionStart = 0;
                    this.selectionEnd = this.val().length;
                } else {
                    // pc和安卓端的方法
                    $(this).focus().select();
                }

            });

            $(".dept-input").on("input", function (e) {
                var v = $(this).val();
                if (v == '') {
                    $(this).val(0);
                }
                //不是數字 => 還原
                if (isNaN(v)) {
                    $(this).val(e.target.defaultValue);
                }
                //檢查Format
                var patt = /^\d+\.{0,1}\d{0,1}$/gi;
                var res = patt.test($(this).val());
                if (res == false) {
                    $(this).val(e.target.defaultValue);
                }

                //更新數值
                e.target.defaultValue = $(this).val();

                //更新項目總數
                var sum = 0;
                $(".dept-input[data-id='" + $(this).data('id') + "']").each(function () {
                    sum += parseInt($(this).val());// * $(this).data('price');
                });
                $("#total_" + $(this).data('id')).html(sum);
                if (sum != parseInt($(".order-qty[data-id='" + $(this).data('id') + "']").html())) {
                    $(".reason[data-id='" + $(this).data('id') + "']").prop("disabled", false);
                    $parentTr = $(this).parents('tr').parents('tr');
                    $parentTr.removeClass();
                    $parentTr.addClass('warning');
                } else {
                    $(".reason[data-id='" + $(this).data('id') + "']").prop("disabled", true);
                }

                //更新部門總數
                sum = 0;
                $(".dept-input[data-dept='" + $(this).data('dept') + "']").each(function () {
                    sum += parseFloat($(this).val()) * $(this).data('price');
                });
                $(".dept-total[data-dept='" + $(this).data('dept') + "']").html(formatMoney(sum));
                $(".dept-total[data-dept='" + $(this).data('dept') + "']").attr("data-sum", sum);

                //更新全單總數
                sum = 0;
                //直接取html()的數字帶有逗號,,計算失敗
                $(".dept-total").each(function () {
                    // console.log(parseFloat($(this).data("sum")));
                    // sum += parseFloat($(this).html());
                    //空的時候不加,否則出錯
                    if ($(this).attr("data-sum")) {
                        sum += parseFloat($(this).attr("data-sum"));
                    }

                });
                // alert(sum);
                $("#all_total").html(formatMoney(sum));
            });

            $(".dept-input").on("blur", function (e) {
                $(this).val(parseInt($(this).val()));
            });
        });

        function checkSubmit() {

            //原因選擇完畢再提交
            var reasonfinish = true;
            $(".reason:enabled").each(function () {
                if ($(this).val() == '0') {
                    $(this).parent('td').addClass('danger');
                    reasonfinish = false;
                    // return false;
                }
            });

            if (reasonfinish == false) {
                Swal.fire({
                    icon: 'warning',
                    title: "請選擇所有原因",
                });
                return false;
            }

            var updatearray = [];

            $(".dept-input").each(function () {
                var mysqlid = $(this).data("mysqlid");
                //修改後數量
                var receivedqty = $(this).val();
                //修改前數量
                var qty = $(this).data("qty");

                var id = $(this).data("id");
                // 數據庫有記錄的才寫入對象;
                if (mysqlid) {

                    //實收與落單數不同時寫入原因
                    if (receivedqty != qty) {
                        var item = {'mysqlid': mysqlid, 'receivedqty': receivedqty ,'oldqty': qty};
                        item.reason = $(".reason[data-id=" + id + "] option:selected").text();
                        updatearray.push(item);
                    }

                }

            });

            console.log(updatearray);

            $.ajax({
                type: "POST",
                url: "{{route('deli.update')}}",
                data: {
                    'updateData': JSON.stringify(updatearray),
                    'shopid' : '{{Request()->shop}}'
                },
                success: function (msg) {
                    if (msg) {
                        alert('發生錯誤！請關閉頁面重新進入\n');
                        console.log(msg);
                    } else {
                        // alert('已確認收貨!\n');

                        Swal.fire({
                            icon: 'success',
                            title: "已確認收貨!",
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: '確定',
                            cancelButtonText: '返回',
                        }).then((result) => {
                            if (result.isDismissed) {
                                window.location.href = '{{route('order.deli.list')}}';
                            } else {
                                window.location.reload();
                            }

                        });

                    }
                }
            });

            // console.log(updatearray);

            // alert('1111');
            // return true;
        }

        function formatMoney(n, c, d, t) {
            var c = isNaN(c = Math.abs(c)) ? 1 : c,
                d = d == undefined ? "." : d,
                t = t == undefined ? "," : t,
                s = n < 0 ? "-" : "",
                i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
                j = (j = i.length) > 3 ? j % 3 : 0;

            return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
        };
    </script>
    <style type="text/css">
        <!--
        body {
            margin-left: 0px;
            margin-top: 0px;
        }

        .style2 {
            font-size: 24px;
            font-weight: bold;
        }

        .style3 {
            font-size: 22px
        }

        input.aa {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
        }

        input.bb {
            text-align: center;
            font-size: 24px;
        }

        .style4 {
            font-size: 24px
        }

        .style6 {
            font-size: 18px;
            font-weight: bold;
        }

        .style9 {
            color: #FF0000
        }

        .style10 {
            font-size: 36px
        }

        .style11 {
            font-size: 16px
        }

        .table1 td {
            padding: 4px 0px;

        }

        #GrpoData > tbody > tr > td {
            border-right: 1px solid black;
            border-bottom: 1px solid black;
            vertical-align: middle;
            text-align: center;
        }

        #GrpoData > tbody > tr > td:last-child {
            border-right: 0px;
        }

        .dept-total {
            display: inline-block;
            width: 70px;
            color: red;
        }

        .dept-input {
            text-align: center;
            font-weight: bold;
        }

        .btn {
            font-weight: bold;
            font-size: 140%;
        }

        -->
    </style>
</head>

<body>
<div align="center" style="width:995px; padding:0px 0px; margin-top: 10px;">
    <table width="98%" border="0" cellspacing="0" cellpadding="0" style="margin:auto;">
        <tbody>
        <tr>
            <td align="center"><span class="style3"><u>分店收貨</u></span></td>
            <td rowspan="2" colspan="3" align="center"><span class="style4">{{$infos->shop}}</span></td>
            <td align="right"><span class="style6">送貨日期:{{$infos->deli_date}}</span></td>
        </tr>
        <tr>
            <td width="25%" align="center"><span class="style3">PO#</span><span class="style10">{{\Carbon\Carbon::parse($infos->deli_date)->isoFormat('YYMMDD')}}</span>
            </td>
            <td width="25%" align="right"><span class="style3">PO日期:{{$infos->deli_date}}</span></td>
        </tr>
    </table>

    <table class="table1" border="1" cellspacing="0" cellpadding="0" style="width:995px; margin:auto; margin-left:1%;">
        {{--        表頭--}}
        @include('order.deli.edit._table_head')
    </table>
    <form>
        <div style="width:995px;  padding-right:30px; margin-right:10px;">
            <div style="width:993px; border:1px solid black; min-height:200px; margin:auto; margin-left:1%;">
                <table class="table table-bordered table-striped" id="GrpoData" cellspacing="0" cellpadding="0"
                       style="width:993px; border-left:0px; border-right:0px; border-top:0px;">
                    @foreach($po as $product_id => $row)
                        @include('order.deli.edit._table_data')
                    @endforeach
                </table>
            </div>

        </div>

                @include('order.deli.edit._total')

        </br>
        <input type="hidden" name="po" value="2020xxxx"/>
        <!--	<button style="font-size:24px; padding:4px; "  onclick="checkSubmit();" value="確認收貨"/>-->
        <button class="btn btn-primary" type="button" onclick="checkSubmit();">&nbsp;確認收貨&nbsp;</button>
        <!-- <button class="btn btn-danger" type="button" onclick="location='grpo.php';">&nbsp;返回&nbsp;</button> -->
    </form>

</div>

</body>

</html>

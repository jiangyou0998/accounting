

<div class="topDiv">
    <div align="left">
        <a target="_top" href="select_day_dept.php?advDays=14" style="font-size: xx-large;">返回</a>
    </div>
    <!-- <form action="order_z_dept_2.php?action=confirm&dept=烘焙" method="post" id="cart" name="cart" target="_top">-->
    <div align="right">
        <strong>
            <font color="#FF0000" size="+3">分店：共食薈(慧霖)            </font>
        </strong>
    </div>
    <div align="right">
        <strong>
            <font color="#FF0000" size="+3">部門：烘焙                <br>送貨日期：8月06日 (四)            </font>
        </strong>
    </div>
</div>

<table width="100%" height="89%" border="1" cellpadding="10" cellspacing="2" id="shoppingcart">
    <tr>
        <td valign="top">
            <table width="100%" border="0" cellspacing="2" cellpadding="2">
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                @include('order._item')
                <tr class="blankline">
                    <td colspan="6">&nbsp;</td>
                </tr>
                <tr>
                    <!-- <td colspan="3" valign="middle">分店：共食薈(慧霖)<br>柯打日期：2020/8/5<br>柯打合共：11</td> -->
                    <td colspan="6" align="center">
                        <input id="btnsubmit" name="Input" type="image"
                               src="images/Confirm.jpg" border="0" onClick="sss();">
                        <input type="image"
                               src="images/Return.jpg" border="0" onclick="top.location.href='select_day_dept.php?advDays=14'">
                        <div align="right">
                            <strong>
                                <font color="#FF0000" size="-2">分店：共食薈(慧霖)</font>
                            </strong>
                        </div>

                        <div align="right">
                            <strong><font color="#FF0000" size="-2">部門：烘焙                                <br>送貨日期：8月06日 (四)</font>
                            </strong>
                        </div>
                    </td>

                </tr>
            </table>
        </td>
    </tr>
</table>
<!-- </form>-->
<script>
    $(document).on('click', '.qty', function () {

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

    $(document).on('change', '.qty', function () {
        var qty = $(this).val();
        var maxQty = 600;
        var base = $(this).data('base');
        var min = $(this).data('min');
        var usertype = 3 ;
        if (qty > maxQty && usertype == 2) {
            alert("每項目數量最多只可為「" + maxQty + "」");
            $(this).val(maxQty);
        } else if (qty < min && usertype == 2) {
            alert("該項目最少落單數量為「" + min + "」");
            $(this).val(min);
        } else if (qty % base != 0 && usertype == 2) {
            alert("該項目數量必須以「" + base + "」為單位");
            var newQty = qty - qty % base;
            $(this).val(newQty);
        }
        ;
    });

    //刪除(x按鈕),隱藏相應行,原本已經存在的
    $(document).on('click', '.del', function () {
        var parent = $(this).parents(".cartold");
        var parentClass = parent.attr("class");
        parent.removeClass(parentClass).addClass("cartdel");
        parent.hide();
        // console.log(parent.attr("class"));

    });

    //刪除(x按鈕),隱藏相應行,新增的行
    $(document).on('click', '.delnew', function () {
        var parent = $(this).parents(".cart");
        var parentClass = parent.attr("class");
        parent.remove();
        // console.log(parent.attr("class"));

    });

    //點擊完成按鈕提交修改
    function sss() {
        //禁止按鈕重複點擊
        $("#btnsubmit").attr('disabled', true);
        var insertarray = [];
        var usertype = 3 ;
        //insert
        $(".cart").each(function () {

            var id = $(this).attr('id');

            var itemid = $(this).data('itemid');
            // console.log($id);

            var qty = $("#qty" + id).val();
            // console.log($qty);

            //管理員可以把數量改成0
            if(qty > 0 || (qty == 0 && usertype == 3)){
                var item = {'itemid': itemid, 'qty': qty};
                insertarray.push(item);
            }



        });

        var updatearray = [];
        //insert
        $(".cartold").each(function () {

            var id = $(this).attr('id');

            var mysqlID = $(this).data('mysqlid');

            var itemid = $(this).data('itemid');
            // console.log($id);

            var qty = $("#qty" + id).val();
            // console.log($qty);

            //管理員可以把數量改成0
            if(qty > 0 || (qty == 0 && usertype == 3)){
                var item = {'mysqlid': mysqlID, 'qty': qty};
                updatearray.push(item);
            }


        });

        var delarray = [];
        //insert
        $(".cartdel").each(function () {

            var mysqlID = $(this).data('mysqlid');

            var item = {'mysqlid': mysqlID};
            delarray.push(item);

        });
        // console.log(JSON.stringify(insertarray));

        $.ajax({
            type: "POST",
            url: "order_z_dept_insert.php",
            data: {
                'insertData': JSON.stringify(insertarray),
                'updateData': JSON.stringify(updatearray),
                'delData': JSON.stringify(delarray)
            },
            success: function (msg) {
                alert('已落貨!');
                window.location.reload();
                // console.log(msg);
            }
        });

    }
</script>



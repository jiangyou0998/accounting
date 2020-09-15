<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="format-detection" content="telephone=no"/>
    <meta name="csrf-token" content="{{csrf_token()}}">
    ﻿​
    <script src="/js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.min.js"
            integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
            crossorigin="anonymous"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>下單-內聯網</title>
</head>

<style type="text/css">
    [class*="col-"] {
        padding: 5px;
    }


</style>

<body>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
</body>
<div class="container-fluid">

    <div class="row">
        <div class="col-6">

            @include('order.cart_item')

        </div>
        <div class="col-6" style="background-color:#697caf">
            <div> @include('order.cart_cat')</div>
            <br>
{{--                        <div class="container-fluid"> @include('order.cart_group')</div>--}}
            <div class="container-fluid group-nav"> </div>
            <hr>
            {{--            <div> @include('order.cart_menu')</div>--}}
                        <div class="container-fluid product-nav"> </div>
        </div>
    </div>
</div>

<script>

    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });

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
        var oldQty = $(this).data('qty');
        var usertype = 2;
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
        if ($(this).val() != oldQty) {
            $(this).addClass('bg-danger');
        } else {
            $(this).removeClass('bg-danger');
        }

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
        // alert(666);
        var parent = $(this).parents(".cart");
        var parentClass = parent.attr("class");
        parent.remove();
        console.log(parent.attr("class"));

    });

    // function aaa(id) {
    //     // alert(666);
    //     // var parent = $(this).parents(".cart");
    //     // var parentClass = parent.attr("class");
    //     // parent.remove();
    //
    //     alert($('#'+id).html());
    //     $('#'+id).remove();
    // }

    function showGroup(catid) {
        // alert("order/cart/show_group/"+catid);
        $.ajax({
            type: "POST",
            url: "/order/cart/show_group/"+catid,
            data: "",
            dataType:'html',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                // console.log(data);
                $(".group-nav").html(data);
                // window.location.reload();
                // // console.log(msg);
            },
            error:function () {
                alert('錯誤!');
                // window.location.reload();
                // // console.log(msg);
            }
        });
    }

    function showProduct(groupid) {
        // alert("order/cart/show_group/"+catid);
        $.ajax({
            type: "POST",
            url: "/order/cart/show_product/"+groupid,
            data: "",
            dataType:'html',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                // console.log(data);
                $(".product-nav").html(data);
                // window.location.reload();
                // // console.log(msg);
            },
            error:function () {
                alert('錯誤!');
                // window.location.reload();
                // // console.log(msg);
            }
        });
    }

    //點擊完成按鈕提交修改
    function sss() {

        //禁止按鈕重複點擊
        // $("#btnsubmit").attr('disabled', true);
        var insertarray = [];
        var usertype = 3;
        //insert
        $(".cart").each(function () {

            var id = $(this).attr('id');

            var itemid = $(this).data('itemid');
            // console.log($id);

            var qty = $("#qty" + id).val();
            // console.log($qty);

            //管理員可以把數量改成0
            if (qty > 0 || (qty == 0 && usertype == 3)) {
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
            if (qty > 0 || (qty == 0 && usertype == 3)) {
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

        // $.ajax({
        //     type: "POST",
        //     url: "order_z_dept_insert.php",
        //     data: {
        //         'insertData': JSON.stringify(insertarray),
        //         'updateData': JSON.stringify(updatearray),
        //         'delData': JSON.stringify(delarray)
        //     },
        //     success: function (msg) {
        //         alert('已落貨!');
        //         window.location.reload();
        //         // console.log(msg);
        //     }
        // });

    }

    function add(itemid, id, suppName, itemName, uom, base, min, overtime) {

        // var topWin = window.top.document.getElementById("leftFrame").contentWindow;
        // var qty = 0;
        // var qty2 = topWin.document.$("#qty100001").val();
        //console.log($("#leftFrame").contents());

        var count = $(".cart,.cartold").length;
        // count += $(topWin.document).find(".cartold").length;
        // alert(count);

        var item = $("#qty" + id);
        if (item.length && item.length>0) {
            // console.log($(item).hasClass('cartdel'));
            var parent = $(item).parents(".cartdel");
            // console.log(parent.attr("class"));
            if (parent.attr("class")) {
                parent.removeClass('cartdel').addClass("cartold");
                parent.show();
                item.value = base;
                return true;
            }
            // qty = topWin.document.getElementById(id).style.display='none';
            var qty = $("#qty" + id).val();
            console.log("#qty" + id);
            $("#qty" + id).val(parseInt(qty) + base) ;
            var qty = parseInt(qty) + base;
            var maxQty = 600;
            if (qty > maxQty) {
                alert("每項目數量最多只可為「" + maxQty + "」");
                $("#qty" + id).val(maxQty);
            } else if (qty < min) {
                alert("該項目最少落單數量為「" + min + "」");
                $("#qty" + id).val(min);
            } else if (qty % base != 0) {
                alert("該項目數量必須以「" + base + "」為單位");
                var newQty = qty - qty % base;
                $("#qty" + id).val(newQty);
            }
            ;
        } else {
            var bg = "#44BBBB";
            if (count & 1) {
                bg = "#44BBBB";
            } else {
                bg = "#AD99CC";
            }

            var tr = "<tr bgcolor=\"" + bg + "\" class=\"cart\" id=" + id + " data-itemid=" + itemid + ">\n" +
                "        <td width=\"10\" align=\"right\">" + (count + 1) + ".</td>\n" +
                "        <td><font color=\"blue\" size=\"-1\">" + suppName + " </font> " + itemName + ",&nbsp;" + id + "</td>\n" +
                "        <td align=\"center\">\n";

            //超過截單時間
            if (overtime) {
                tr += "<img src=\"images/alert.gif\" width=\"20\" height=\"20\"> ";
            }
            // "        <img src="images/alert.gif" width="20" height="20">        \n" +
            tr += "\t\t</td>\n" +
                "        <td width=\"100\" align=\"center\">x \n" +
                "          <input class=\"qty\" type=\"tel\" id=\"qty" + id + "\" name=\"1136\" type=\"text\" value=" + min + " data-base=" + base + " data-min=" + min + " size=\"3\" maxlength=\"4\" autocomplete=\"off\"></td>\n" +
                "        <td align=\"center\">" + uom + "</td>\n" +
                "        <td align=\"center\">\n" +
                "\t\t\t<a href=\"#\" class=\"delnew\"><font color=\"#FF6600\">X</font></a>\n" +
                "\t\t</td>\n" +
                "      </tr>";

            $(".blankline").before(tr);
            count += 1;

            // if(count > 0){
            //     $(topWin.document).find(".cart").eq(count-1).after(tr);
            //     count += 1;
            // }else{
            //
            //     // alert(count);
            // }

        }
        // console.log(qty);
    }

    function drop(id, base, min) {

        var topWin = window.top.document.getElementById("leftFrame").contentWindow;
        // var qty = 0;
        // var qty2 = topWin.document.$("#qty100001").val();
        //console.log($("#leftFrame").contents());

        // var count = $(topWin.document).find(".cart").length;

        if (topWin.document.getElementById("qty" + id)) {
            // qty = topWin.document.getElementById(id).style.display='none';
            var qty = topWin.document.getElementById("qty" + id).value;
            topWin.document.getElementById("qty" + id).value = parseInt(qty) - base;
            var qty = parseInt(qty) - base;
            var maxQty = 600;
            if (qty > maxQty) {
                alert("每項目數量最多只可為「" + maxQty + "」");
                topWin.document.getElementById("qty" + id).value = maxQty;
            } else if (qty < min) {
                alert("該項目最少落單數量為「" + min + "」");
                topWin.document.getElementById("qty" + id).value = min;
            } else if (qty % base != 0) {
                alert("該項目數量必須以「" + base + "」為單位");
                var newQty = qty - qty % base;
                topWin.document.getElementById("qty" + id).value = newQty;
            }
            ;
        }
        // console.log(qty);
    }
</script>

</html>



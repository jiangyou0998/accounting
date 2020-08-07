<div class="topDiv">
    <div align="left">
        <a target="_top" href="select_day_dept.php?advDays=14" style="font-size: xx-large;">返回</a>
    </div>
    <!-- <form action="order_z_dept_2.php?action=confirm&dept=烘焙" method="post" id="cart" name="cart" target="_top">-->
    <div align="right">
        <strong>
            <font color="#FF0000" size="+3">分店：共食薈(慧霖) </font>
        </strong>
    </div>
    <div align="right">
        <strong>
            <font color="#FF0000" size="+3">部門：烘焙 <br>送貨日期：8月06日 (四) </font>
        </strong>
    </div>
</div>

<table width="100%" height="89%" border="1" cellpadding="10" cellspacing="2" id="shoppingcart">
    <tr>
        <td valign="top">
            <table width="100%" border="0" cellspacing="2" cellpadding="2">
                @foreach($items as $itemCount => $item)
                    @include('order._item')
                @endforeach

                @foreach($sampleItems as $itemCount => $item)
                    @include('order._sample_item')
                @endforeach
                <tr class="blankline">
                    <td colspan="6">&nbsp;</td>
                </tr>
                <tr>
                    <!-- <td colspan="3" valign="middle">分店：共食薈(慧霖)<br>柯打日期：2020/8/5<br>柯打合共：11</td> -->
                    <td colspan="6" align="center">
                        <input id="btnsubmit" name="Input" type="image"
                               src="/images/Confirm.jpg" border="0" onClick="sss();">
                        <input type="image"
                               src="/images/Return.jpg" border="0"
                               onclick="top.location.href='select_day_dept.php?advDays=14'">
                        <div align="right">
                            <strong>
                                <font color="#FF0000" size="-2">分店：共食薈(慧霖)</font>
                            </strong>
                        </div>

                        <div align="right">
                            <strong><font color="#FF0000" size="-2">部門：烘焙 <br>送貨日期：8月06日 (四)</font>
                            </strong>
                        </div>
                    </td>

                </tr>
            </table>
        </td>
    </tr>
</table>
<!-- </form>-->




<form name="orderByFi" action="order_z_dept_left.php" target="leftFrame" method="get">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tbody><tr>
            <td height="39"></td>
            <td align="left">&nbsp;

            </td>
            <td width="50" align="center" bgcolor="#FFFF00" style="color:black;">現貨</td>
            <!-- <td width="50" align="center" bgcolor="#D7710D">新貨</td>
            <td width="50" align="center" bgcolor="#008081">季節貨</td>
            -->
            <td width="50" align="center" bgcolor="#7D0101">已截單</td>
            <!--<td width="50" align="center" bgcolor="#666666">暫停</td>-->
        </tr>
        </tbody></table>

    <br>
    <br>
    <div class="container-fluid">
        <div class="row">
            @foreach($products as $product)
                @include('sample._product')
            @endforeach
        </div>
    </div>

</form>

{{--购物车Item--}}
<tr @if($itemCount % 2) bgcolor="#A2A2A2" @else bgcolor="#FFFFFF" @endif
    class="cartold" id="{{$item->chr_no}} "
    data-itemid="{{$item->itemID}}" data-mysqlid="{{$item->orderID}}">
    <td width="10" align="right">{{$itemCount + 1}}.</td>
    <td><font
              size=-1>{{$item->suppName}} </font>{{$item->itemName}}, {{$item->chr_no}}                        </td>
    <td align="center">
        <img title='已超過截單時間' src='/images/alert.gif' width='20' height='20'>                        </td>
    <td width="100" align="center">x
        <input class="qty" type="tel"
               id="qty{{$item->chr_no}} "
               name="{{$item->orderID}}"
               type="text" value="{{round($item->int_qty,2)}}"
               data-base="{{$item->int_base}} "
               data-min="{{$item->int_min}} "
               size="3" maxlength="4"
               autocomplete="off"
        >
    </td>
    <td align="center">{{$item->UoM}}</td>
    <td align="center">
        <a href="#" class="del"><font color="#FF6600">X</font></a>
    </td>
</tr>

{{--购物车Item--}}
<tr @if($itemCount % 2) bgcolor="#A2A2A2" @else bgcolor="#FFFFFF" @endif
    class="cartold" id="{{$item->product_no}} "
    data-itemid="{{$item->itemID}}" data-mysqlid="{{$item->orderID}}">
    <td width="10" align="right">{{$itemCount + 1}}.</td>
    <td><font
              size=-1>{{$item->suppName}} </font>{{$item->itemName}}, {{$item->product_no}}                        </td>
    <td align="center">
                              </td>
    <td width="100" align="center">x
        <input class="qty" type="tel"
               id="qty{{$item->product_no}}"
               name="{{$item->orderID}}"
               type="text" value="{{round($item->qty,2)}}"
               data-base="{{$item->base}}"
               data-min="{{$item->min}}"
               data-qty="{{round($item->qty,2)}}"
               size="3" maxlength="4"
               autocomplete="off"
        >
    </td>
    <td align="center">{{$item->UoM}}</td>
    <td align="center">
        <a href="#" class="del"><span style="color: #FF6600; ">X</span></a>
    </td>
</tr>

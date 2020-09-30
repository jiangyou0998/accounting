{{--购物车Item--}}
<tr @if($itemCount % 2) bgcolor="#A2A2A2" @else bgcolor="#FFFFFF" @endif
    class="cartold" id="{{$item->product_no}} "
    data-itemid="{{$item->itemID}}" data-mysqlid="{{$item->orderID}}">
    <td width="10" align="right">{{$itemCount + 1}}.</td>
    <td><font
              size=-1>{{$item->suppName}} </font>{{$item->itemName}}, {{$item->product_no}}                        </td>
    <td align="center">

        @if($item->cut_order)
            <img title='已超過截單時間' src='/images/alert.gif' width='20' height='20'>
        @endif

        @if($item->not_deli_time)
            <img title='不在貨期' src='/images/del_3.png' width='20' height='20'>
        @endif

        @if($item->order_by_workshop)
            <img title='後勤落單' src='/images/help1.png' width='20' height='20'>
        @endif

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
        @if($item->invalid_order && Auth::user()->cannot('workshop')) disabled @endif

        >
    </td>
    <td align="center">{{$item->UoM}}</td>
    <td align="center">
        @if(!$item->invalid_order || Auth::user()->can('workshop'))
            <a href="javascript:void(0);" class="del"><span style="color: #FF6600; ">X</span></a>
        @endif
    </td>
</tr>

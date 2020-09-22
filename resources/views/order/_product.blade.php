

<div class="col-4 text-center">
    <table class="item" width="100%"
        @if($product->invalid_order)
           style="background-color:#7D0101;margin: 3px;"
        @else
           style="background-color:#FFFF00;margin: 3px;"
        @endif
    >
        <tbody>
        <tr>
            <td colspan="4" align="left" style="font-size:12px;
            @if($product->order_by_workshop || $product->cut_order || $product->not_deli_time)
                color: white;
            @else
                color: black;
            @endif">
                {{$product->product_no}}
            </td>
        </tr>
        <tr>
            <td colspan="4" align="center" style="font-size:16px;">
                <span style="
                @if($product->order_by_workshop || $product->cut_order || $product->not_deli_time)
                    color: white;
                @else
                    color: black;
                @endif">{{$product->product_name}}</span>
                    <br>
{{--                    後勤落單判斷--}}
                    @if($product->order_by_workshop)
                        <span style="color: red;font-size:8px;">
                            後勤落單
                        </span>
                    @else
                        <span style="color: red;font-size:8px;">
                            {{$product->phase}}日前&nbsp;{{substr_replace($product->cuttime, ':', 2, 0)}}截單
                        </span>
                    @endif
                                                                                </span>
                    <br>
                    <span style="color: red;font-size:8px;">
                        出貨期:{{$product->canordertime}}                                                            </span>
                </span>
            </td>
        </tr>
        <tr>
            @if(Auth::user()->can('workshop') or Auth::user()->can('operation') or
            !$product->invalid_order
            )
                <td style="height:20px; width:50%; font-size:24px; text-align:center" colspan="2">
                    <a id="itm-{{$product->id}}" href="javascript:;" onclick="add({{$product->id}},{{$product->product_no}},'麵包','{{$product->product_name}}','個',{{$product->base}},{{$product->min}},1)">
                        <button type="button" style="height:100%; width:100%; font-size:18px;">
                            +
                        </button>
                    </a>
                </td>

                <td style="height:20px; width:50%; font-size:24px; text-align:center" colspan="2">
                    <a id="itm-{{$product->id}}" href="javascript:;" onclick="drop({{$product->product_no}},{{$product->base}},{{$product->min}})" style="color:black;">
                        <button type="button" style="height:100%; width:100%; font-size:18px;">
                            -
                        </button>
                    </a>
                </td>
            @endif
        </tr>
        </tbody>
    </table>
</div>

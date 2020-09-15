

<div class="col-4 text-center ">
    <table class="item" width="100%"  style="background-color:#7D0101; color:white;margin: 3px;">
        <tbody>
        <tr>
            <td colspan="4" align="left" style="font-size:12px; color: white;">
                {{$product->product_no}}
            </td>
        </tr>
        <tr>
            <td colspan="4" align="center" style="font-size:16px;">
                <span style="color: white;">{{$product->product_name}}
                    <br>
                    <span style="color: red;font-size:8px;">
                        {{$product->phase}}日前&nbsp;{{$product->cuttime}}截單                                                            </span>
                    <br>
                    <span style="color: red;font-size:8px;">
                        出貨期:{{$product->canordertime}}                                                            </span>
                </span>
            </td>
        </tr>
        <tr>
            <td style="height:20px; width:50%; font-size:24px; text-align:center" colspan="2">
                <a id="itm-{{$product->id}}" href="javascript:;" onclick="add({{$product->id}},{{$product->product_no}},'麵包','咸麵粒','個',{{$product->base}},{{$product->min}},1)">
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
        </tr>
        </tbody>
    </table>
</div>

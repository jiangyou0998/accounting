<style>
    .checkbox {
        font-size: 30px;
        margin-bottom: 10px;
    }
    input[type="checkbox"] {
        width: 30px;
        height: 30px;
    }
</style>

<div class="topDiv div-fixed">
    <div align="left">
        <a target="_top" href="{{route('sample')}}" style="font-size: xx-large;">返回</a>
    </div>
    @if($sample->id)
        <div align="middle"><strong><font color="#FF0000" size="+15">修改範本
                </font></strong></div>
    @else
        <div align="middle"><strong><font color="#FF0000" size="+15">創建範本
                </font></strong></div>
    @endif



    <!-- <form action="order_z_dept_2.php?action=confirm&dept=烘焙" method="post" id="cart" name="cart" target="_top">-->
    <div align="right">
        <strong>
            <font color="#FF0000" size="+3">分店：{{$orderInfos->shop_name}} </font>
        </strong>
    </div>
    <div align="left" style="padding-top: 15px;"><strong><font color="#FF0000" size="+3">選擇星期:
            </font></strong>

    </div>
    {!! $checkHtml !!}
    @if($sample->id)
        <input type="hidden" name="weekstr" id="weekstr" value="{{$currentdate}}"/>
    @else
        <input type="hidden" name="weekstr" id="weekstr" value=""/>
    @endif
</div>



<div class="item-body">

    <table width="100%" height="89%" border="1" cellpadding="10" cellspacing="2" id="shoppingcart">
        <tr>
            <td valign="top">
                <table width="100%" border="0" cellspacing="2" cellpadding="2">

                    @if($sample->id)
                        @foreach($sampleItems as $itemCount => $item)
                            @include('sample._item')
                        @endforeach
                    @endif
                    <tr class="blankline">
                        <td colspan="6">&nbsp;</td>
                    </tr>

                </table>
            </td>
        </tr>
        <tr>

            <td colspan="6" align="center">
{{--                <input id="btnsubmit" name="Input" type="image"--}}
{{--                       src="/images/Confirm.jpg" border="0" onClick="sss();">--}}
{{--                <input type="image"--}}
{{--                       src="/images/Return.jpg" border="0"--}}
{{--                       onclick="{{route('sample')}}">--}}
                <a class="btn btn-primary btn-lg" href="#" role="button" onClick="sss();">落貨</a>
                <a class="btn btn-success btn-lg" href="{{route('sample')}}" role="button">返回</a>
            </td>

        </tr>
    </table>
    <!-- </form>-->



</div>



<tr @if($row['totalqty'] != $row['totalreceivedqty']) class="danger" @endif>
    <td width="125px" align="center" bgcolor="#FFFFFF">{{$row['name']}}</td>
    <td width="75px" align="center" bgcolor="#FFFFFF">{{$row['price']}}</td>
    <td width="75px" align="center" bgcolor="#FFFFFF">
        <span style="width:50px; text-align:right;" class="order-qty" data-id="{{$product_id}}">
		{{$row['totalqty']}}</span>
        {{$row['unit']}}
    </td>
    <td width="75px" align="center" bgcolor="#FFFFFF">
        <span style="width:50px; text-align:right;" class="order-qty" data-id="{{$product_id}}">
        {{$row['totalreceivedqty']}}</span>
        {{$row['unit']}}
    </td>
    <td width="434px" align="center" bgcolor="#FFFFFF">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
                <td width="24%" align="center">
                    <span style="width:50px; text-align:right;" id="total_{{$product_id}}">
					{{$row['totalreceivedqty']}}</span>
                    {{$row['unit']}}
                </td>

                @foreach($deptArr as $dept)

                    @if(isset($row['qty'][$dept]))
                        <td width="15%" align="center">
                            <input name="item[{{$product_id}}][{{$dept}}]"
                                   data-mysqlid="{{$row['qty'][$dept]['mysqlid']}}"
                                   data-price="{{$row['price']}}"
                                   data-dept="{{$dept}}"
                                   data-id="{{$product_id}}"
                                   data-qty="{{number_format($row['qty'][$dept]['qty'], 2, '.', ',')}}"
                                   value="{{number_format($row['qty'][$dept]['qty'], 2, '.', ',')}}"
                                   class="dept-input" type="number" autocomplete="off"
                                   style="width:95%; margin:auto;">
                        </td>
                    @else
                        <td width="15%" align="center">
                            <input name="item[{{$product_id}}][{{$dept}}]"
                                   data-mysqlid=""
                                   data-price="{{$row['price']}}"
                                   data-dept="{{$dept}}"
                                   data-id="{{$product_id}}"
                                   data-qty="0"
                                   value="0"
                                   class="dept-input" type="number" autocomplete="off"
                                   style="width:95%; margin:auto;" disabled>
                        </td>
                    @endif

                @endforeach

            </tr>
            </tbody>
        </table>
    </td>
    <td width="160px" align="center" bgcolor="#FFFFFF">
        <select name="reason[{{$product_id}}]" class="reason" data-id="{{$product_id}}" style="width:95%; margin:auto; font-size:14px;"
                @if($row['totalqty'] == $row['totalreceivedqty']) disabled @endif>

            @foreach ($reasonArr as $key => $value)
                @if ($row['reason'] == $value){
                    <option value="{{$key}}" selected>{{$value}}</option>
                @else
                    <option value="{{$key}}">{{$value}}</option>
                @endif
            @endforeach

        </select>
    </td>
</tr>

{{----}}

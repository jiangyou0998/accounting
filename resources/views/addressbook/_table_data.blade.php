@foreach($shop_addresses as $shop_address)
    @foreach($shop_address->users_with_addresses as $value)
        <tr>
            <th rowspan="4" align="left">{{$value->address->shop_name}}</th>
            <td align="center" style="padding:0px;">
                <table width="100%" height="100%">
                    <tbody><tr>
                        <th width="15%" align="left" valign="top" style="border-right:2px solid black;">中文地址
                        </th>
                        <td>{{$value->address->address}}</td>
                    </tr>
                    </tbody></table>
            </td>
        </tr>
        <tr>
            <td align="center" style="padding:0px;">
                <table width="100%">
                    <tbody><tr>
                        <th width="15%" align="left" valign="top" style="border-right:2px solid black;">英文地址
                        </th>
                        <td><i>{{$value->address->eng_address}}</i></td>
                    </tr>
                    </tbody></table>
            </td>
        </tr>
        <tr>
            <td align="center" style="padding:0px;">
                <table width="100%">
                    <tbody><tr>
                        <th width="15%" align="left" valign="top" style="border-right:2px solid black;">營業時間
                        </th>
                        <td><i>{!! $value->address->oper_time !!}</i></td>
                    </tr>
                    </tbody></table>
            </td>
        </tr>

        <tr>
            <td align="center" style="padding:0px;">
                <table width="100%">
                    <tbody><tr>
                        <th width="15%" align="left" valign="top" style="border-right:2px solid black;">電　話</th>
                        <td width="35%" style="border-right:2px solid black;">{{$value->address->tel}}</td>
                        <th width="15%" align="left" valign="top" style="border-right:2px solid black;">ＦＡＸ</th>
                        <td width="35%">{{$value->address->fax}}</td>
                    </tr>
                    </tbody></table>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center" style="padding:0px;background-color:#ffffcc;">&nbsp;</td>
        </tr>
    @endforeach
@endforeach



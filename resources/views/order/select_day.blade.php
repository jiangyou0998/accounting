@extends('layouts.app')

@section('content')

    <div align="left"><a target="_top" href="{{route('order')}}" style="font-size: xx-large;">返回</a></div>
    <center class="style5">
        請選<span class="style4">送貨日</span>及<span class="style4">部門</span>
        <br>
        <br>
        落貨分店


        <select style="width:200px;" id="shop">
            <option value="0">請選擇分店</option>
            <option value="76">貳號冰室(華欣樓)</option>
            <option value="73">一口烘焙(長發)</option>
            <option value="32">共食薈(開源道)</option>
            <option value="31">共食薈(慧霖)</option>
            <option value="6">蛋撻王(大業)</option>
            <option value="7">蛋撻王(宏開)</option>
            <option value="8">蛋撻王(宏啟)</option>
            <option value="33">蛋撻王(油塘)</option>
            <option value="37">蛋撻王(逸東)</option>
            <option value="34">蛋撻王(欣榮)</option>
            <option value="38">蛋撻王(禾輋)</option>
            <option value="36">蛋撻王(樂富)</option>
            <option value="39">蛋撻王(新都城II)</option>
            <option value="5">蛋撻王(愛東)</option>
            <option value="35">蛋撻王(泓景匯)</option>
            <option value="40">蛋撻王(天晉)</option>
            <option value="69">蛋撻王(東南樓)</option>
            <option value="70">蛋撻王(光華)</option>
            <option value="80">蛋撻王(利東街)</option>
            <option value="9">糧友(荃灣)</option>
            <option value="42">糧友(黃埔)</option>
            <option value="43">糧友(東港)</option>
            <option value="44">糧友(將中)</option>
            <option value="45">糧友(YOHO)</option>
            <option value="74">糧友(上中)</option>
            <option value="10">糧友(MOKO)</option>
            <option value="86">糧友(梭椏道)</option>
            <option value="90">糧友(奧海城)</option>
            <option value="77">測試店</option>
        </select>
        <br>
        <br>

        <input type="radio" name="dept" id="radio" value="R" checked>烘焙
        <input type="radio" name="dept" id="radio" value="B">水吧
        <input type="radio" name="dept" id="radio" value="K">廚房
        <input type="radio" name="dept" id="radio" value="F">樓面
    </center>
    <table class="table table-bordered border-dark" width="100%" border="2" align="center" cellpadding="3" cellspacing="0">
        @foreach($dayArray as $key => $day)
        <tr class="daylist" >
            <td align="right" width="48%"><strong>{{$day['desc']}}</strong></td>
            <td align="left" width="52%"><a
                    href="{{route('cart','deli_date='.$day['deli_date'])}}"><strong>{{$day['dayStr']}}</strong></a>
            </td>
        </tr>
        @endforeach
    </table>
    <br>
    <center class="style3">不同送貨日<span class="style4">必須</span>分單</center>

@endsection

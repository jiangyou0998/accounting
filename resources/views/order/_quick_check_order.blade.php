<!-- 快速進入 -->
<h6 class="d-flex justify-content-between align-items-center mb-3">
    <span class="text-muted">最近下單數量</span>
</h6>
<ul class="list-group mb-3">


        <table class="table">
            <tbody class="table-striped" style="background-color: white">
            @foreach($countArr[$shop] as $day => $count)
                @if($loop->iteration % 3 == 1 || $loop->first)
                    <tr class="bg-blue">
                        @endif
                        <td style="text-align: center">
                            <a href="
                            @if($shop === 'rb')
                            {{route('order.deli',['deli_date' => $day])}}
                            @elseif ($shop === 'kb')
                            {{route('kb.order.deli',['deli_date' => $day])}}
                            @endif
                                "
                               target="_blank" @if($count === "未下單") style="color: red" @endif>
                                {{$count}}
                            </a>
                            <div>

                                <small>{{\Carbon\Carbon::parse($day)->isoFormat('MM-DD(dd)')}}</small>
                            </div>
                        </td>
                    @if($loop->iteration % 3 == 0 || $loop->last)
                        <tr>
                    @endif
                    @endforeach
            </tbody>
        </table>

</ul>

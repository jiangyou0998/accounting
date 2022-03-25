<table width="100%" border="1" align="center" cellpadding="3" cellspacing="0">
    <div class="style5" style="text-align: center;">
        <span class="style4">{{$samples['name']}}</span>
    </div>
    <div style="margin-bottom: 10px;">
        <button class="sizefont"><a class="btn btn-primary" href="{{route('kb.sample.create',['dept'=>'CU', 'type' => ($samples['type'] ?? '') ])}}">新建{{ ($samples['name'] ?? '') }}範本</a></button>
    </div>
    @foreach($samples['samples'] as $sample)
        @if($sample->dept == 'CU')
            <tr style="margin-top: 60px" class="sizefont">
                <td align="right" width="4%"><strong>#</strong></td>

                <td align="left"><a
                        href="{{route('kb.sample.edit',$sample->id)}}"><strong>{{$sample->sampledate}}</strong></a>
                </td>
                <td align="middle" width="10%"><strong>
                        <button onclick="delsample({{$sample->id}});">刪除範本</button>
                    </strong></td>
            </tr>
        @endif
    @endforeach

</table>

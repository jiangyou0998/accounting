<div style="font-size: x-large;text-align: right; padding-top: 6px">
    <b>
        @if(request()->type == 'CUR')
            SALES RETURN
        @endif
        TOTAL&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;HKD{{ number_format($data['infos']->total, 2) }}
    </b>
</div>
{{--<div style="font-size: medium;text-align: left;"><b>{{ $infos->total_english }}</b></div>--}}



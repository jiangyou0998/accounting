<br>

@if (config('app.debug'))
    <div>
        <span style="color: red;font-size: x-large">TEST EMAIL</span>
    </div>
@endif

<div>
    申請時間&nbsp;:&nbsp;{{ \Carbon\Carbon::now()->toDateTimeString() }}
</div>


<div>
{{--    員工編號:<span style="color: red;font-size: large">{{ $claim->employee->code }}</span>--}}
    員工編號&nbsp;:&nbsp;{{ $claim->employee->code }}
</div>

<div>
{{--    員工姓名:<span style="color: red;font-size: large">{{ $claim->employee->name }}</span>--}}
    員工姓名&nbsp;:&nbsp;{{ $claim->employee->name }}
</div>

<div>
    索償類型&nbsp;:&nbsp;{{ $claim->claim_level->type_name }}
</div>

<div>
{{--    中文佔位符&#12288;--}}
    病&#12288;&#12288;症&nbsp;:&nbsp;{{ $claim->illness->item_name }}
</div>

<div>
    收據總額&nbsp;:&nbsp;HKD${{ number_format($claim->cost, 2) }}
</div>

<div>
    診症日期&nbsp;:&nbsp;{{ $claim->claim_date }}
</div>

<div>
    LINK&nbsp;:&nbsp; <a href="{{ admin_url('claims')."?employee_id={$claim->employee_id}" }}">LINK</a>
</div>

<br>

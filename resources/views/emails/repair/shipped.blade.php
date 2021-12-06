<br>

@if (config('app.debug'))
    <div>
        <span style="color: red;font-size: x-large">TEST EMAIL</span>
    </div>
@endif

<div>
    時間:{{\Carbon\Carbon::now()->toDateTimeString()}}
</div>

<div>
    分店/用戶:<span style="color: red;font-size: large">{{$repair->users->txt_name}}</span>
</div>

<div>
    維修單編號:<span style="color: red;font-size: large">{{$repair->repair_project_no}}</span>
</div>

<div>
    緊急性:<span style="color: red;font-size: large">{{$repair->importance}}</span>
</div>

<div>
    位置:{{$repair->locations->name}}
</div>

<div>
    維修項目:{{$repair->items->name}}
</div>

<div>
    求助事宜:{{$repair->details->name}}
</div>

<div>
    機器號碼#{{$repair->machine_code}}
</div>

<div>
    其他資料提供:{{$repair->other}}
</div>

<div>
    IP:{{$repair->ip}}
</div>

<br>

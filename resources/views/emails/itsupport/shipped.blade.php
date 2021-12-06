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
    分店/用戶:<span style="color: red;font-size: large">{{$itsupport->users->txt_name}}</span>
</div>

<div>
    維修單編號:<span style="color: red;font-size: large">{{$itsupport->it_support_no}}</span>
</div>

<div>
    緊急性:<span style="color: red;font-size: large">{{$itsupport->importance}}</span>
</div>

<div>
    器材:{{$itsupport->items->name}}
</div>

<div>
    求助事宜:{{$itsupport->details->name}}
</div>

<div>
    機器號碼#{{$itsupport->machine_code}}
</div>

<div>
    其他資料提供:{{$itsupport->other}}
</div>

<div>
    IP:{{$itsupport->ip}}
</div>

<br>

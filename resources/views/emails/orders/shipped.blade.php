<br>

<div>
    時間:{{\Carbon\Carbon::now()->toDateTimeString()}}
</div>


<div>
    分店:{{$itSupport->users->txt_name}}
</div>

<div>
    維修單編號:{{$itSupport->it_support_no}}
</div>

<div>
    緊急性:
</div>

<div>
    器材:{{$itSupport->items->name}}
</div>

<div>
    求助事宜:{{$itSupport->details->name}}
</div>

<div>
    機器號碼#{{$itSupport->machine_code}}
</div>

<div>
    其他資料提供:{{$itSupport->other}}
</div>

<div>
    IP:{{$itSupport->ip}}
</div>

<br>

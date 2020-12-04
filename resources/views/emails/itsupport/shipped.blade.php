<br>

<div>
    時間:{{\Carbon\Carbon::now()->toDateTimeString()}}
</div>


<div>
    分店/用戶:{{$itsupport->users->txt_name}}
</div>

<div>
    維修單編號:{{$itsupport->it_support_no}}
</div>

<div>
    緊急性:{{$itsupport->importance}}
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

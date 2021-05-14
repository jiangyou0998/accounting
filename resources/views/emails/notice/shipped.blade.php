
<h1>通告:<span style="color:red">{{$notice->notice_name ?? '無標題'}}</span></h1>

<h3>
    時間:{{\Carbon\Carbon::now()->toDateTimeString()}}
</h3>

<div>
    @if(is_array($files))
        @foreach ($files as $file => $name)
            <div>
                <span>附件{{$loop->iteration}}:</span>
                <a href="{{$file}}">{{$name ?? '無標題'}}</a>
            </div>
        @endforeach
    @else
        <div>
            <span>附件:</span>
            <a href="{{$files}}">{{$notice->notice_name ?? '無標題'}}</a>
        </div>
    @endif
</div>

<br><br>
<div>※此信件由系統發出，請勿直接回覆。若有任何問題，請連繫發信單位或業務連絡人</div>

<br>

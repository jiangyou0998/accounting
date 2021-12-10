<table border="1" bordercolor="#ccc" cellspacing="0" cellpadding="0">

    @foreach($allUnfinished as $user_id => $unfinished)
        <div class="text-center">
            <h2>{{ $users[$user_id] }}</h2>
        </div>
        <br>
        <hr>
        @foreach($unfinished as $itsupport)
            <div>
                時間:{{ $itsupport->created_at }}
            </div>

            <div>
                分店/用戶:<span style="color: red;font-size: large">{{ $itsupport->users->txt_name ?? '' }}</span>
            </div>

            <div>
                維修單編號:<span style="color: red;font-size: large">{{ $itsupport->itsupport_project_no }}</span>
            </div>

            <div>
                緊急性:<span style="color: red;font-size: large">{{ $itsupport->importance }}</span>
            </div>

            <div>
                器材:{{ $itsupport->items->name ?? '' }}
            </div>

            <div>
                求助事宜:{{ $itsupport->details->name ?? '' }}
            </div>

            @if( $itsupport->machine_code )
                <div>
                    機器號碼#{{ $itsupport->machine_code }}
                </div>
            @endif

            @if( $itsupport->other )
                <div>
                    其他資料提供:{{ $itsupport->other }}
                </div>
            @endif

            @if( $itsupport->contact_person )
                <div>
                    負責人:{{ $itsupport->contact_person }}
                </div>
            @endif

            @if( $itsupport->file_path )
                <a href="{{ $itsupport->file_path }}" style="font-size:x-large" target="_blank">附檔</a>
            @endif

            <br>
            <hr>
            @endforeach
    @endforeach

</table>


<table border="1" bordercolor="#ccc" cellspacing="0" cellpadding="0">

    @foreach($allUnfinished as $user_id => $unfinished)
        <div class="text-center">
            <h2>
                <a href="{{route('repair.phone.view', $user_id)}}">{{ $users[$user_id] ?? '' }}</a>
            </h2>
            <button class="btn btn-success btn-lg repair-order" value="{{ $user_id }}">開單</button>
        </div>
        <br>
        <hr>

        @foreach($unfinished as $repair)
            <div id="row">
                <div class="col-md-1 order-md-1">
                    <input type="checkbox" name="repair-group-{{ $user_id }}" value="{{ $repair->id }}">

                </div>
                <div class="col-md-11 order-md-1">
                    <div>
                        時間:{{ $repair->created_at }}
                    </div>

                    <div>
                        分店/用戶:<span style="color: red;font-size: large">{{ $repair->users->txt_name ?? '' }}</span>
                    </div>

                    <div>
                        維修單編號:<span style="color: red;font-size: large">{{ $repair->repair_project_no }}</span>
                    </div>

                    <div>
                        緊急性:<span style="color: red;font-size: large">{{ $repair->importance }}</span>
                    </div>

                    <div>
                        位置:{{ $repair->locations->name ?? '' }}
                    </div>

                    <div>
                        維修項目:{{ $repair->items->name ?? '' }}
                    </div>

                    <div>
                        求助事宜:{{ $repair->details->name ?? '' }}
                    </div>

                    @if( $repair->machine_code )
                        <div>
                            機器號碼#{{ $repair->machine_code }}
                        </div>
                    @endif

                    @if( $repair->other )
                        <div>
                            其他資料提供:{{ $repair->other }}
                        </div>
                    @endif

                    @if( $repair->contact_person )
                        <div>
                            負責人:{{ $repair->contact_person }}
                        </div>
                    @endif

                    @if( $repair->file_path )
                        <a href="{{ $repair->file_path }}" style="font-size:x-large" target="_blank">附檔</a>
                    @endif

                    <br>
                    <hr>

                </div>

            </div>

        @endforeach
    @endforeach


</table>


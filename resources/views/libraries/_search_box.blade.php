{{--首頁搜索框右對齊--}}
@if(if_route('library.index'))
    <div class="d-flex justify-content-end input-group">
@else
    <div class="d-flex justify-content-between input-group">
        @if(if_route('library.search'))
            <a target="_top" href="{{ route('library.index') }}" style="font-size: xx-large;">返回</a>
        @else
            <a target="_top" href="javascript:history.back(-1);" style="font-size: xx-large;">返回</a>
        @endif
@endif

    <form class="card p-1" method="POST" action="{{route('library.search')}}">
        <div class="input-group">
            @csrf
            <input id="keyword" name="keyword" type="text" class="form-control" placeholder="" value="">
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">查詢</button>
            </div>
        </div>
    </form>
</div>

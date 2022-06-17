{{--            <ul class="nav nav-tabs">--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link @if(request()->has('times') && request()->times == 0) active @endif"--}}
{{--                       href="{{ route('stock.warehouse.index', ['date' => request()->date]) }}">#全部--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--            @foreach($saved_supplier_ids as $saved_supplier_id)--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link @if(request()->supplier == $saved_supplier_id && request()->type == 'filled') active @endif"--}}
{{--                       href="{{ route('stock.warehouse.index', ['type' => 'filled', 'date' => request()->date, 'supplier' => $saved_supplier_id]) }}">#{{$suppliers[$saved_supplier_id] ?? ''}}--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--            @endforeach--}}
{{--            </ul>--}}

{{--            已保存invoice tab--}}
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        @foreach($tabs as $supplier_id => $tab)
            <a class="nav-item nav-link" id="nav-{{$supplier_id}}-tab" data-toggle="tab" href="#nav-{{$supplier_id}}" role="tab" aria-controls="nav-profile" aria-selected="false">{{$suppliers[$supplier_id]}}</a>
        @endforeach
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    @foreach($tabs as $supplier_id => $tab)
        <div class="tab-pane fade" id="nav-{{$supplier_id}}" role="tabpanel" aria-labelledby="nav-profile-tab">
            @foreach($tab as $date => $value)
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">
                            {{$date}}
                            @foreach($value as $date => $v)
                            <a href="{{route('stock.warehouse.edit', ['times' => $v['times']])}}"
                               style="padding-right: 5px;">
                                #{{$v['invoice_no']}}
                            </a>
                            @endforeach
                        </h6>
                    </div>
                </li>
            @endforeach
        </div>

    @endforeach
    {{--                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">...</div>--}}
</div>

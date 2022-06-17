 @foreach($suppliers as $supplier_id => $supplier)
    @foreach($warehouse_groups as $warehouse_group_id => $warehouse_group)
        @isset($products[$supplier_id][$warehouse_group_id])
            @if($filled_count === 0)
                <h1><a href="{{ route('stock.warehouse.index', ['supplier' => $supplier_id, 'date' => request()->date]) }}">{{ $supplier }}</a>{{ '-' . $warehouse_group }}</h1>
            @else
                <h1>{{ $supplier . '-' . $warehouse_group }}</h1>
            @endif

            <table class="table">

                <thead class="thead-dark">
                <tr>
                    <th scope="col" width="15%">編號</th>
                    <th scope="col" width="20%">貨名</th>
                    <th scope="col" width="20%">結存</th>
                    <th scope="col" width="10%">包裝</th>
                    <th scope="col" width="20%">結存</th>
                    <th scope="col" width="10%">包裝</th>
                    <th scope="col" width="10%"></th>
                </tr>
                </thead>

                <tbody class="table-striped" style="background-color: white">
                @foreach($products[$supplier_id][$warehouse_group_id] as $product)
                    <tr @if($product->unit->unit_name === '箱') class="table-danger @endif">
                        <td>{{$product->product_no}}</td>
                        <td>{{$product->product_name_short}}</td>
{{--                            數值輸入1--}}
                        <td>
                            <input class="qty" type="number"
                                   data-id="{{$product->id}}"
                                   data-unit="{{ $product->unit->id ?? 0 }}"
                                   style="width:100%"
                                   value="{{ $stockitems[$product->id][$product->unit->id] ?? ''}}">
                        </td>
{{--                            單位1--}}
                        <td>
                            <span>{{ $product->unit->unit_name ?? '' }}</span>
                        </td>

                        @if($product->unit_id === $product->base_unit_id)
                            <td></td>
                            <td></td>
                        @else
{{--                            數值輸入2--}}
                        <td>
                            <input class="qty" type="number"
                                   data-id="{{$product->id}}"
                                   data-unit="{{ $product->base_unit->id ?? 0 }}"
                                   style="width:100%"
                                   value="{{ $stockitems[$product->id][$product->base_unit->id] ?? ''}}">
                        </td>
{{--                            單位2--}}
                        <td>
                            <span>{{ $product->base_qty ?? '' }}/{{ $product->base_unit->unit_name ?? '' }}</span>
                        </td>
                        @endif
{{--                            刪除按鈕--}}
                        <td>
                            <a href="javascript:void(0);" class="delstock"
                               data-id="{{$product->id}}">
                                <span style="color: #FF6600; ">X</span>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endisset
    @endforeach
@endforeach


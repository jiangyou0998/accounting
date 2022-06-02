 @foreach($suppliers as $supplier_id => $supplier)
    @foreach($warehouse_groups as $warehouse_group_id => $warehouse_group)
        @isset($products[$supplier_id][$warehouse_group_id])
            <h1>{{ $supplier . '-' . $warehouse_group }}</h1>
            <table class="table">

                <thead class="thead-dark">
                <tr>
                    <th scope="col" width="15%">編號</th>
                    <th scope="col" width="50%">貨名</th>
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
{{--                            數值輸入--}}
                        <td>
                            <input class="qty" type="number"
                                   data-id="{{$product->id}}"
                                   data-unit="{{ $product->unit->id ?? 0 }}"
                                   style="width:100%"
                                   value="{{ $stockitems[$product->id] ?? ''}}">
                        </td>
{{--                            單位--}}
                        <td>
                            @if($product->unit_id === $product->base_unit_id)
                                <span>{{ $product->unit->unit_name }}</span>
                            @else
                                <select class="select_unit" data-id="{{$product->id}}">
                                    <option value="{{ $product->unit->id ?? 0 }}"
                                            @if(isset($stockitem_units[$product->id]) && $stockitem_units[$product->id] === $product->unit->id) selected @endif>
                                        {{ $product->unit->unit_name ?? '' }}
                                    </option>
                                    <option value="{{ $product->base_unit->id ?? 0 }}"
                                            @if(isset($stockitem_units[$product->id]) && $stockitem_units[$product->id] === $product->base_unit->id) selected @endif>
                                        {{ $product->base_unit->unit_name ?? '' }}
                                    </option>
                                </select>
                            @endif
                        </td>
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


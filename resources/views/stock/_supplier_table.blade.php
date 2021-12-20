@foreach($suppliers as $supplier_id => $supplier)
    @foreach($groups as $group_id => $group)
        @isset($products[$supplier_id][$group_id])
            <h1>{{ $supplier . '-' . $group }}</h1>
            <table class="table">

                <thead class="thead-dark">
                <tr>
                    <th scope="col" width="15%">編號</th>
                    <th scope="col" width="50%">貨名</th>
                    <th scope="col" width="20%">結存</th>
                    <th scope="col" width="15%">包裝</th>
                </tr>
                </thead>

                <tbody class="table-striped" style="background-color: white">
                @foreach($products[$supplier_id][$group_id] as $product)
                    @if(request()->type !== 'empty')
                        <tr @if($product->unit->unit_name === '箱') class="table-danger @endif">
                            <td>{{$product->product_no}}</td>
                            <td>{{$product->product_name}}</td>
                            <td>
                                <input class="qty" type="number"
                                       data-id="{{$product->id}}"
                                       style="width:100%"
                                       value="{{ $stockitems[$product->id] ?? ''}}">
                            </td>
                            <td>
                                @if($product->unit_id === $product->base_unit_id)
                                    {{ $product->unit->unit_name }}
                                @else
                                    <select name="" id="">
                                        <option value="">{{ $product->unit->unit_name ?? '' }}</option>
                                        <option value="">{{ $product->base_unit->unit_name ?? '' }}</option>
                                    </select>
                                @endif
                            </td>
                        </tr>
                        {{--                    只顯示未填寫的--}}
                    @elseif(request()->type === 'empty' && ! isset($stockitems[$product->id]))
                        <tr @if($product->unit->unit_name === '箱') class="table-danger @endif">
                            <td>{{$product->product_no}}</td>
                            <td>{{$product->product_name}}</td>
                            <td>
                                <input class="qty" type="number"
                                       data-id="{{$product->id}}"
                                       style="width:100%"
                                       value="">
                            </td>
                            <td>
                                @if($product->unit_id === $product->base_unit_id)
                                    {{ $product->unit->unit_name }}
                                @else
                                    <select name="" id="">
                                        <option value="">{{ $product->unit->unit_name ?? '' }}</option>
                                        <option value="">{{ $product->base_unit->unit_name ?? '' }}</option>
                                    </select>
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        @endisset
    @endforeach
@endforeach


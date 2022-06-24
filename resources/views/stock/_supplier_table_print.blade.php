@foreach($suppliers as $supplier_id => $supplier)
    @foreach($groups as $group_id => $group)
        @isset($products[$supplier_id][$group_id])
            <h4>{{ $supplier . '-' . $group }}</h4>
            <table class="table">

                <thead class="thead-dark">
                <tr>
                    <th scope="col" width="15%"></th>
                    <th scope="col" width="50%"></th>
                    <th scope="col" width="10%"></th>
                    <th scope="col" width="10%"></th>
                    <th scope="col" width="10%"></th>
                    <th scope="col" width="10%"></th>
                </tr>
                </thead>

                <tbody class="table-striped" style="background-color: white">
                @foreach($products[$supplier_id][$group_id] as $product)

                        <tr>
                            <td>{{$product->product_no}}</td>
                            <td>{{$product->product_name_short}}</td>
{{--                            數值輸入--}}
                            <td>
                                {{ $stockitems[$product->id][$product->unit->id] ?? ''}}
                            </td>
{{--                            單位--}}
                            <td>
                                <span>{{ $product->unit->unit_name }}</span>
                            </td>

{{--                            數值輸入2--}}
                            @if($product->unit_id === $product->base_unit_id)
                                <td></td>
                                <td></td>
                            @else
                                <td>
                                    {{ $stockitems[$product->id][$product->base_unit->id] ?? ''}}
                                </td>
{{--                            單位2--}}
                                <td>
{{--                                    <span>{{ $product->base_qty ?? '' }}/{{ $product->base_unit->unit_name ?? '' }}</span>--}}
                                    <span>{{ $product->base_unit->unit_name ?? '' }}</span>
                                </td>
                            @endif

                        </tr>

                @endforeach
                </tbody>
            </table>
        @endisset
    @endforeach
@endforeach


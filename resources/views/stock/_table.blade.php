@foreach($groups as $key => $value)
    @isset($products[$key])
        <h1>{{$value}}</h1>
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
            @foreach($products[$key] as $product)
{{--                    判斷是否未填寫--}}
                @if(request()->type !== 'empty' ||
                    ( request()->type === 'empty' && ! isset($stockitems[$product->id]) )
                    )
                    <tr @if($product->unit->unit_name === '箱') class="table-danger @endif">
                        <td>{{$product->product_no}}</td>
                        <td>{{$product->product_name}}</td>
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
                            <span>{{ $product->unit->unit_name }}</span>
                        </td>
{{--                            刪除按鈕--}}
                        <td>
                            <a href="javascript:void(0);" class="delstock"
                               data-id="{{$product->id}}">
                                <span style="color: #FF6600; ">X</span>
                            </a>
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    @endisset
@endforeach


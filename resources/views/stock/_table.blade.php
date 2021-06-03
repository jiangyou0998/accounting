@isset($products[$key])
    <h1>{{$value}}</h1>
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
            @foreach($products[$key] as $product)
                <tr @if($product->units->unit_name === '箱') class="table-danger @endif">
                    <td>{{$product->product_no}}</td>
                    <td>{{$product->product_name}}</td>
                    <td>
                        <input class="qty" type="number"
                               data-id="{{$product->id}}"
                               style="width:100%"
                               value="{{ $stockitems[$product->id] ?? ''}}">
                    </td>
                    <td>{{$product->units->unit_name}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endisset


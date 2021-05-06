@isset($products[$key])
    <h1>{{$value}}</h1>
    <table class="table">

        <thead class="thead-dark">
        <tr>
            <th scope="col">編號</th>
            <th scope="col">貨名</th>
            <th scope="col">結存</th>
            <th scope="col">包裝</th>
        </tr>
        </thead>

        <tbody class="table-striped" style="background-color: white">
            @foreach($products[$key] as $product)
                <tr @if($product->units->unit_name === '箱') class="table-danger @endif">
                    <td>{{$product->product_no}}</td>
                    <td>{{$product->product_name}}</td>
                    <td><input type="number" name="" id=""></td>
                    <td>{{$product->units->unit_name}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endisset


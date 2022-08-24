
            <h4>
                @foreach($shops as $shop)
                    @if(in_array($shop->id, explode(',', request()->shop_ids)))
                        {{$shop->report_name}}
                    @endif
                @endforeach
            </h4>
            <table class="table">

                <thead class="thead-dark">
                <tr>
                    <th scope="col" width="5%">#</th>
                    <th scope="col" width="10%">產品編號</th>
                    <th scope="col" width="30%">產品名稱</th>
                    <th scope="col" width="20%">價格</th>
                    <th scope="col" width="10%">數量</th>
                    <th scope="col" width="10%">單位</th>
                    <th scope="col" width="10%">總計</th>
                </tr>
                </thead>

                @foreach($products as $product)
                <tbody class="table-striped" style="background-color: white">
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$productInfosArr[$product->product_id]['product_no'] ?? ''}}</td>
                            <td>{{$productInfosArr[$product->product_id]['product_name'] ?? ''}}</td>
                            @if($product->min_price < $product->max_price)
                                <td>${{number_format($product->min_price, 2)}} - ${{number_format($product->max_price, 2)}}</td>
                            @else
                                <td>${{number_format($product->max_price, 2)}}</td>
                            @endif
                            <td>{{number_format($product->qty, 0)}}</td>
                            <td>{{$unitInfoArr[$product->unit_id]['unit_name'] ?? ''}}</td>
                            <td>${{number_format($product->po_total, 2)}}</td>

                        </tr>

                </tbody>
                @endforeach
            </table>


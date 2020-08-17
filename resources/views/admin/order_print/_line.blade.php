<tr bgcolor="#FFFFFF">
@foreach($data->toArray() as $k => $v)
    @include('admin.order_print._item')
@endforeach
</tr>

<table border="0" cellpadding="0" cellspacing="2">
    <tr>
        @foreach($cats as $cat)
            @include('kb.order._cat')
        @endforeach
    </tr>
</table>

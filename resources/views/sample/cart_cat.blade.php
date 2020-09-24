<table border="0" cellpadding="0" cellspacing="2">
    <tr>
        @foreach($cats as $cat)
            @include('sample._cat')
        @endforeach
    </tr>
</table>

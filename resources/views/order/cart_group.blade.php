<div class="row">
    <table id="tblist" border="0" cellpadding="0" cellspacing="2">
        <tbody>
        <tr>
            @foreach($groups as $group)
                @include('order._group')
            @endforeach
        </tr>
        </tbody>
    </table>

</div>

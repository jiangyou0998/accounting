<div class="row">
{{--    <table id="tblist" border="0" cellpadding="0" cellspacing="2">--}}
{{--        <tbody>--}}
{{--        <tr>--}}
            @foreach($groups as $key=>$group)
                @include('customer.order._group')
            @endforeach
{{--        </tr>--}}
{{--        </tbody>--}}
{{--    </table>--}}

</div>

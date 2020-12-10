@foreach($shop_groups as $shop_group_id => $shop_group)
    <li class="list-group-item d-flex justify-content-between lh-condensed">
        <div>
            <h6 class="my-0">
                <a href="{{route('addressbook',['group'=> $shop_group_id])}}">
                    {{$shop_group}}
                </a>
            </h6>
        </div>
    </li>
@endforeach


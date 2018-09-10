<ul>
    @foreach($list as $key => $item)
        <li>
            @if($relation_route)
                <a  target="_blank"
                    href="{!! route($relation_route, $item->{$relation_route_id}) !!}">
                    {!! $item->{$relation_field} !!}
                </a>
            @else
                {!! $item->{$relation_field} !!}
            @endif
        </li>
    @endforeach
</ul>

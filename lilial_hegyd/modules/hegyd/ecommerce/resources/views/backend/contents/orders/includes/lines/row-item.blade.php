<tr>
    <td class="text-left">{{ $line->product_name }}</td>
    <td>{{ $line->product_reference }}</td>
    <td class="basket-price text-center">{{ app_number_format($line->unit_price_ht) }}&nbsp;€</td>
    <td class="basket-price text-center">{{ app_number_format($line->unit_price_ttc) }}&nbsp;€</td>
    <td class="basket-quantity text-center">{{ $line->quantity }}</td>
    <td class="basket-price text-right">{{ app_number_format($line->total_ht) }}&nbsp;€</td>
    <td class="actions">
        {{--@if($model->status < \Hegyd\eCommerce\Models\eCommerce\Order::STATUS_ARCHIVED)--}}
        {{--<a class="btn btn-white btn-sm edit_line"--}}
           {{--href="{{ route(config('hegyd-ecommerce.routes.backend.order.lines.edit'), ['id' => $model->id, 'line_id' => $line->id]) }}">--}}
            {{--<i class="fa fa-pencil"></i>--}}
        {{--</a>--}}
        {{--<a class="btn btn-white btn-sm remove_line"--}}
           {{--href="{{ route(config('hegyd-ecommerce.routes.backend.order.lines.destroy'), ['id' => $model->id, 'line_id' => $line->id]) }}">--}}
            {{--<i class="fa fa-trash"></i>--}}
        {{--</a>--}}
        {{--@endif--}}
    </td>
</tr>

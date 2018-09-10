<tr>
    <td class="text-left">{{ $line->product_name }}</td>
    <td>{{ $line->product_reference }}</td>
    <td>{{ app_number_format($line->unit_price_ht) }}&nbsp;€</td>
    <td>{{ app_number_format($line->unit_price_ttc) }}&nbsp;€</td>
    <td>{{ $line->quantity }}</td>
    <td>{{ app_number_format($line->total_ht) }}&nbsp;€</td>
    {{--<td>{{ app_number_format($line->vat_rate) }}&nbsp;%</td>--}}
    {{--<td>{{ app_number_format($line->total_ttc) }}&nbsp;€</td>--}}
</tr>

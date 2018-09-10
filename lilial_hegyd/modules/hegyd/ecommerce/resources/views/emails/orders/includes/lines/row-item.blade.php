<tr>
    <td class="productItem" align="center">
        <a href="{{ $line->product ? route(config('hegyd-ecommerce.routes.frontend.product.show'), $line->product->id) : '' }}" target="_blank">
            {{ $line->product_reference }}
        </a>
    </td>
    <td class="productItem" align="left" valign="middle" style="text-align:left">
        <a href="{{ $line->product ? route(config('hegyd-ecommerce.routes.frontend.product.show'), $line->product->id) : '' }}" target="_blank">
            {{ $line->product_name }}
        </a>
    </td>
    <td class="productItem" align="center">
        {{ app_number_format($line->unit_price_ht) }}&nbsp;€
    </td>
    <td class="productItem" align="center">
        {{ app_number_format($line->unit_price_ttc) }}&nbsp;€
    </td>
    <td class="productItem" align="center">
        {{ $line->quantity }}
    </td>
    <td class="productItem" align="center" style="text-align:right;">
        {{ app_number_format($line->total_ht) }}&nbsp;€
    </td>
</tr>
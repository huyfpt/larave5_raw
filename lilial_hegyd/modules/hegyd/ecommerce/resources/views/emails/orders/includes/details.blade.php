@inject('orderService', 'Hegyd\eCommerce\Services\eCommerce\OrderService')
<!-- COMMANDE - SPACE TOP BEGIN -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td heigt="35" style="height:35px;">&nbsp;</td>
    </tr>
</table>
<!-- COMMANDE - SPACE TOP END -->

<table class="tabRequest" width="100%" cellpadding="0" cellspacing="0">
    <thead style="background:#f5f5f5">
    <tr style="background:#f5f5f5">
        <th class="tableHeader" align="center" width="15%" >
            @lang('hegyd-ecommerce::orders.fields.product_reference')
        </th>
        <th class="tableHeader" width="50%" >
            @lang('hegyd-ecommerce::orders.fields.product_name')
        </th>
        <th class="tableHeader" align="center" width="5%" >
            @lang('hegyd-ecommerce::orders.fields.unit_price_ht')
        </th>
        <th class="tableHeader" align="center" width="5%" >
            @lang('hegyd-ecommerce::orders.fields.unit_price_ttc')
        </th>
        <th class="tableHeader" align="center" width="5%" >
            @lang('hegyd-ecommerce::orders.fields.quantity')
        </th>
        <th class="tableHeader" align="center" width="20%" >
            @lang('hegyd-ecommerce::orders.fields.total_ht')
        </th>
    </tr>
    </thead>

    <tbody>
    @if($order->lines->count())
        @foreach($order->lines as $line)
            @include('hegyd-ecommerce::emails.orders.includes.lines.row-item')
        @endforeach

        <tr>
            <td class="empty" colspan="3" rowspan="4"
                style="border:none;padding:10px 0 10px 0" valign="middle">
                <p><b>@lang('hegyd-ecommerce::orders.fields.payment_means')</b></p>
                @if($paid_at = $order->paid_at)
                <p>
                  @lang('hegyd-ecommerce::orders.messages.paid_at', [
                 'date'     => $paid_at->format('d/m/Y H:i:s'),
                 'provider' => app(\Hegyd\eCommerce\Services\eCommerce\OrderService::class)->paymentMeansText($order->payment_means)
                 ])
                </p>
                @endif
            </td>
            <td colspan="2" class="totalPriceTitle" align="left" >
                @lang('hegyd-ecommerce::orders.fields.delivery_price')
            </td>
            <td class="totalPrice">
                {{ app_number_format($order->delivery_price) }}&nbsp;€
            </td>
        </tr>
        <tr>
            <td colspan="2" class="totalPriceTitle">
                @lang('hegyd-ecommerce::orders.fields.total_ht')
            </td>
            <td class="totalPrice">
                    {{ app_number_format($order->total_ht) }}&nbsp;€
            </td>
        </tr>
        <tr>
            <td colspan="2" class="totalPriceTitle">
                @lang('hegyd-ecommerce::orders.fields.total_vat')
            </td>
            <td class="totalPrice">
                    {{ app_number_format($order->total_vat) }}&nbsp;€
            </td>
        </tr>
        {{--<tr>--}}
            {{--<td colspan="2" class="totalPriceTitle">--}}
                {{--@lang('hegyd-ecommerce::rders.fields.delivery_price')--}}
            {{--</td>--}}
            {{--<td class="totalPrice">--}}
                {{--{{ app_number_format($order->delivery_price) }}&nbsp;€--}}
            {{--</td>--}}
        {{--</tr>--}}
        <tr>
            <td colspan="2" class="totalPriceTitle">
                @lang('hegyd-ecommerce::orders.fields.total_ttc')
            </td>
            <td class="totalPrice">
                <strong>{{ app_number_format($order->total_ttc) }}&nbsp;€</strong>
            </td>
        </tr>
    @else
        <tr><td colspan="5">@lang('hegyd-ecommerce::orders.labels.no_product')</td></tr>
    @endif
    </tbody>
</table>
<!-- COMMANDE - Block command-lines END -->
<table width="100%" cellspacing="0" cellpadding="0" class="wrap body" style="border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;color:#787878;font-family:Helvetica, Arial, sans-serif;font-size:12px;background-color:#FFFFFF">
    <tr style="padding:0">
        <td height="25" style="height:25px;border-bottom:1px dotted #E1E1E1;border-collapse:collapse;padding:0">&nbsp;</td>
    </tr>
    <tr style="padding:0">
        <td height="25" style="height:25px;border-collapse:collapse;padding:0">&nbsp;</td>
    </tr>
</table>

<!-- COMMANDE - Block address BEGIN -->
<table width="100%" cellspacing="0" cellpadding="0" class="mailAdress">
    <tr>
        <td valign="top" bgcolor="#f5f5f5" width="28%" style="padding:2%;color:#4c4c4c">
            <div style="font-family: Arial, Helvetica, sans-serif; font-size:12px;text-transform: uppercase;padding: 4px 0 8px 0;border-bottom:2px solid #d8d8d8">
                @lang('hegyd-ecommerce::orders.labels.invoice_address')
            </div>
            <div style="font-family: Arial, Helvetica, sans-serif; font-size:12px;padding: 15px 0 8px 0;line-height:20px">
                <address>
                    <strong>{{ $order->invoice_firstname }} {{ $order->invoice_lastname }}</strong><br>
                    {{ $order->invoice_address }}, <br>
                    @if($order->invoice_additional_1)
                        {{ $order->invoice_additional_1 }}, <br>
                    @endif
                    @if($order->invoice_additional_2)
                        {{ $order->invoice_additional_2 }}, <br>
                    @endif
                    {{ $order->invoice_zip }} {{ $order->invoice_city }}<br>
                    @if($order->invoice_country)
                        {{ $order->invoice_country }}<br>
                    @endif
                    @if($order->invoice_phone)
                        @lang('app.labels.phone', ['phone' => $order->invoice_phone])<br>
                    @endif
                    @if($order->invoice_email)
                        @lang('app.labels.email', ['email' => $order->invoice_email])
                    @endif
                </address>
            </div>
        </td>
        <td class="space" width="1%" style="width:2%;">&nbsp;</td>

        <td valign="top" bgcolor="#f5f5f5" width="28%" style="padding:2%;color:#4c4c4c">
            <div style="font-family: Arial, Helvetica, sans-serif; font-size:12px;text-transform: uppercase;padding: 4px 0 8px 0;border-bottom:2px solid #d8d8d8">
                @lang('hegyd-ecommerce::orders.labels.delivery_address')
            </div>
            <div style="font-family: Arial, Helvetica, sans-serif; font-size:12px;padding: 15px 0 8px 0;line-height:20px">
                <address>
                    <strong>{{ $order->delivery_firstname }} {{ $order->delivery_lastname }}</strong><br>
                    {{ $order->delivery_address }}, <br>
                    @if($order->delivery_additional_1)
                        {{ $order->delivery_additional_1 }}, <br>
                    @endif
                    @if($order->delivery_additional_2)
                        {{ $order->delivery_additional_2 }}, <br>
                    @endif
                    {{ $order->delivery_zip }} {{ $order->delivery_city }}<br>
                    @if($order->delivery_country)
                        {{ $order->delivery_country }}<br>
                    @endif
                    @if($order->delivery_phone)
                        @lang('app.labels.phone', ['phone' => $order->delivery_phone])<br>
                    @endif
                    @if($order->delivery_email)
                        @lang('app.labels.email', ['email' => $order->delivery_email])
                    @endif
                </address>
            </div>
        </td>
    </tr>
</table>
@if($order->comment)
    <table width="100%" cellspacing="0" cellpadding="0" class="wrap body" style="border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;color:#787878;font-family:Helvetica, Arial, sans-serif;font-size:12px;background-color:#FFFFFF">
        <tr style="padding:0">
            <td height="25" style="height:25px;border-bottom:1px dotted #E1E1E1;border-collapse:collapse;padding:0">&nbsp;</td>
        </tr>
        <tr style="padding:0">
            <td height="25" style="height:25px;border-collapse:collapse;padding:0">&nbsp;</td>
        </tr>
    </table>

    <table width="100%" cellspacing="0" cellpadding="0" class="mailAdress">
        <tr>
            <td valign="top" bgcolor="#f5f5f5" style="padding:2%;color:#4c4c4c">
                <div style="font-family: Arial, Helvetica, sans-serif; font-size:12px;text-transform: uppercase;padding: 4px 0 8px 0;border-bottom:2px solid #d8d8d8">
                    @lang('hegyd-ecommerce::orders.fields.comment')
                </div>
                <div style="font-family: Arial, Helvetica, sans-serif; font-size:12px;padding: 15px 0 8px 0;line-height:20px">
                    {{ $order->comment }}
                </div>
            </td>
        </tr>
    </table>
@endif
<table cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td heigt="35" style="height:35px;">&nbsp;</td>
    </tr>
</table>

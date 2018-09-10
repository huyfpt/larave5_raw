@extends(config('hegyd-ecommerce.main_layout.email'))

@section('message')
    @lang('hegyd-ecommerce::emails.products.stock-alert.message')
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
                @lang('hegyd-ecommerce::products.fields.reference')
            </th>
            <th class="tableHeader" width="50%" >
                @lang('hegyd-ecommerce::products.fields.name')
            </th>
            <th class="tableHeader" align="center" width="20%" >
                @lang('hegyd-ecommerce::products.fields.stock')
            </th>
        </tr>
        </thead>

        <tbody>
        @foreach($products as $product)
            <tr>
                <td class="productItem" align="center">
                    <a href="{{ $product ? route(config('hegyd-ecommerce.routes.frontend.product.show'), $product->id) : '' }}" target="_blank">
                        {{ $product->reference }}
                    </a>
                </td>
                <td class="productItem" align="left" valign="middle" style="text-align:left">
                    <a href="{{ $product ? route(config('hegyd-ecommerce.routes.frontend.product.show'), $product->id) : '' }}" target="_blank">
                        {{ $product->name }}
                    </a>
                </td>
                <td class="productItem" align="center">
                    {{$product->stock}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <table cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td heigt="35" style="height:35px;">&nbsp;</td>
        </tr>
    </table>
@endsection


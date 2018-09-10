<a class="btn btn-default"
   href="{{ route(config('hegyd-ecommerce.routes.frontend.order.show'), $object->id) }}"
   title="@lang('hegyd-ecommerce::orders.buttons.show_detail')">
    <i class="fa fa-eye"></i>
</a>
<a href="{{ route(config('hegyd-ecommerce.routes.frontend.order.download-invoice'), $object->id) }}"
   class="btn btn-default"
   target="_blank"
   title="@lang('hegyd-ecommerce::orders.buttons.download_invoice')">
    <i class="fa fa-download"></i>
</a>
<a href="{{ route(config('hegyd-ecommerce.routes.frontend.order.re-order'), $object->id) }}"
   class="btn btn-default"
   target="_blank"
   title="@lang('hegyd-ecommerce::orders.buttons.re_order')">
    <i class="fa fa-repeat"></i>
</a>
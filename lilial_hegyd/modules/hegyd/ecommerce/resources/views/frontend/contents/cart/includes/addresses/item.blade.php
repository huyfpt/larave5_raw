<div class="address-content">
    @if($address)
        <p class="address-info">
            @if($address->company)
                <span class="address-company">{{ $address->company }}</span>
                <br>
            @endif
            @if($address->firstname && $address->lastname)
                <span class="address-customer">{{ $address->firstname }} {{ $address->lastname }}</span>
                <br>
            @endif
            @if($address->email)
                <span class="address-email">{{ $address->email }}</span>
                <br>
            @endif
            @if($address->phone)
                <span class="address-phone">{{ $address->phone }}</span>
            @endif
        </p>
        <p class="address-loc">
            <span class="address-road">{{ $address->address }}</span>
            @if($address->additional_1)
                <br>
                <span class="address-road">{{ $address->additional_1 }}</span>
            @endif
            @if($address->additional_2)
                <br>
                <span class="address-place">{{ $address->additional_2 }}</span>
            @endif
            <br>
            <span class="address-city">{{ $address-> zip }} {{ $address->city }}</span>
            @if($address->country)
                <br>
                <span class="address-country">{{ $address->country->title_fr }}</span>
            @endif
        </p>
    @else
        <p class="address-info text-center alert alert-danger">
            @lang('hegyd-ecommerce::cart.labels.please_choose_address')
        </p>
    @endif
    <p class="text-center choose-btn">
        <a href="{{ route(config('hegyd-ecommerce.routes.frontend.cart.address.list'), ['type' => $type]) }}"
           class="btn btn-default choose-address">
            @lang('hegyd-ecommerce::cart.buttons.choose_an_address')
        </a>
    </p>
</div>
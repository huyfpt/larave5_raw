<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">{!! $title !!}</h4>
</div>
<div class="modal-body">
    <div class="row list-addresses">
        <div class="col-md-6">
            <div class="add-address">
                <a href="{{ route(config('hegyd-ecommerce.routes.frontend.cart.address.add'), ['type' => $type]) }}" class="add-address">
                    <i class="fa fa-plus-circle"></i>
                    <span>@lang('hegyd-ecommerce::cart.title.add_address')</span>
                </a>
            </div>
        </div>

        @if($addresses->count())
            @foreach($addresses as $address)
                <div class="col-md-6">
                    {!! Form::open(['route' => $route, 'method' => $method, 'class' => 'form-horizontal']) !!}
                    {!! Form::hidden('address_id', $address->id) !!}
                    {!! Form::hidden('type', $type) !!}
                    <div class="address-item">
                        <div class="desc">
                            <h4>{{$address->name}}</h4>
                            <p class="address-info">
                                <span class="address-customer">{{ $address->address }}</span>
                                @if($address->additional_1)
                                    <span class="address-road">{{ $address->additional_1 }}</span>
                                @endif
                                @if($address->additional_2)
                                    <span class="address-place">{{ $address->additional_2 }}</span>
                                @endif
                            </p>
                            <p class="address-loc">
                                <span class="address-city">{{ $address-> zip }} {{ $address->city }}</span>
                                @if($address->country)
                                    <br>
                                    <span class="address-country">{{ $address->country->title_fr }}</span>
                                @endif
                            </p>
                        </div>
                        <div class="text-center buttons">
                            {!! Form::submit(trans('hegyd-ecommerce::cart.buttons.choose_this_address'), ['class' => 'btn btn-primary text-uppercase']) !!}
                            <a href="{{ route(config('hegyd-ecommerce.routes.frontend.cart.address.edit'), ['id' => $address->id, 'type' => $type]) }}"
                               class="btn btn-default text-uppercase edit-address">
                                @lang('hegyd-ecommerce::cart.buttons.update_address')
                            </a>
                        </div>
                    </div>
                    {!!Form::close()!!}
                </div>
            @endforeach
        @endif

        <div class="col-md-12 loading hide text-center">
            <i class="fa fa-circle-o-notch fa-spin text-danger fa-5x"></i>
        </div>
    </div>
</div>
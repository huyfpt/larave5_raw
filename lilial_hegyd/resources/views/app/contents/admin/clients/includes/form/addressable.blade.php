@php
    !isset($prefix) ? $prefix = 'addresses' : '';
    !isset($relation) ? $relation = 'address' : '';
    !isset($relation_error) ? $relation_error = 'address' : '';
    !isset($label_class) ? $label_class='col-md-2' : null;
    !isset($field_div_class) ? $field_div_class = 'col-md-10' : '';
    !isset($form_group_class) ? $form_group_class='' : null;

    if(strstr($_SERVER['REQUEST_URI'], 'clients') == true)
    {
        $model = $model->user;
        $address = $model->address->address;
        $city = $model->address->city;
        $zip = $model->address->zip;
    } else
    {
        $address = $model->address->address;
        $city = $model->address->city;
        $zip = $model->address->zip;
    }
@endphp
<div class="addressable_form">
    <div class="form-group {{$form_group_class}} {!! Form::hasError($relation_error . 'address', $errors) !!}">
        <label class="{{$label_class}} control-label">@lang($prefix . '.fields.address')
            @if(isset($required['address']) && $required['address'])
                <i class="required-field">*</i>
            @endif
        </label>
        <div class="{{ $field_div_class }}">
            {!! Form::text($relation . '[address]', $address, [
            'class' => 'form-control address',
             isset($required['address']) && $required['address'] ? 'required' : ''
             ]) !!}
            {!! Form::errorMsg($relation_error . 'address', $errors) !!}
        </div>
    </div>
    {{--<div class="form-group {{$form_group_class}} {!! Form::hasError($relation_error . 'additional_1', $errors) !!}">
        <label class="{{$label_class}} control-label">@lang($prefix . '.fields.additional_1')
            @if(isset($required['additional_1']) && $required['additional_1'])
                <i class="required-field">*</i>
            @endif
        </label>
        <div class="{{ $field_div_class }}">
            {!! Form::text($relation . '[additional_1]', null, [
            'class' => 'form-control additional_1',
             isset($required['additional_1']) && $required['additional_1'] ? 'required' : ''
             ]) !!}
            {!! Form::errorMsg($relation_error . 'additional_1', $errors) !!}
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="form-group {{$form_group_class}} {!! Form::hasError($relation_error . 'additional_2', $errors) !!}">
        <label class="{{$label_class}} control-label">@lang($prefix . '.fields.additional_2')
            @if(isset($required['additional_2']) && $required['additional_2'])
                <i class="required-field">*</i>
            @endif
        </label>
        <div class="{{ $field_div_class }}">
            {!! Form::text($relation . '[additional_2]', null, [
            'class' => 'form-control additional_2',
             isset($required['additional_2']) && $required['additional_2'] ? 'required' : ''
             ]) !!}
            {!! Form::errorMsg($relation_error . 'additional_2', $errors) !!}
        </div>
    </div>
    @php
        if ($model->address && $model->address->country_id){
            $country = $model->address->country;
            $selectedCountryId = $country->id;
            $selectedCountry = [$country->id => $country->title_fr];
        } else {
            $france = \App\Models\Common\Country::where('iso_alpha_2', 'FR')->first();
            $selectedCountryId = null;
            $selectedCountry = [];

            if($france)
            {
                $selectedCountryId = null;
                $selectedCountry = [$france->id => $france->title_fr];;
            }
        }
    @endphp

    @include('app.includes.form.select2', [
        'select_id'         => 'country_id',
        'label'             => $prefix . '.fields.country',
        'required'          => isset($required['country']) && $required['country'] ? true : false,
        'field'             => $relation . '[country_id]',
        'field_error'       => $relation_error . 'country_id',
        'values'            => $selectedCountry,
        'selected_value'    => $selectedCountryId,
        'label_class'       => $label_class,
        'div_class'         => $field_div_class,
        'form_group_class'  => $form_group_class,
        'class'             => 'country'
    ])
    <div class="form-group {{$form_group_class}} {!! Form::hasError($relation_error . 'city', $errors) !!}">
        <label class="{{$label_class}} control-label">@lang($prefix . '.fields.city')
            @if(isset($required['city']) && $required['city'])
                <i class="required-field">*</i>
            @endif
        </label>
        <div class="{{ $field_div_class }}">
            {!! Form::text($relation . '[city]', $city, [
            'class' => 'form-control city',
             isset($required['city']) && $required['city'] ? 'required' : ''
             ]) !!}
            {!! Form::errorMsg($relation_error . 'city', $errors) !!}
        </div>
    </div>--}}
    <div class="form-group {{$form_group_class}} {!! Form::hasError($relation_error . 'zip', $errors) !!}">
        <label class="{{$label_class}} control-label">@lang($prefix . '.fields.zip')
            @if(isset($required['zip']) && $required['zip'])
                <i class="required-field">*</i>
            @endif
        </label>
        <div class="{{ $field_div_class }}">
            {!! Form::number($relation . '[zip]', $zip, [
            'class' => 'form-control zip',
             isset($required['zip']) && $required['zip'] ? 'required' : '']) !!}
            {!! Form::errorMsg($relation_error . 'zip', $errors) !!}
        </div>
    </div>
    <div class="clearfix"></div>
    {{--<div class="form-group {{$form_group_class}} {!! Form::hasError($relation_error . 'city', $errors) !!}">
        <label class="{{$label_class}} control-label">@lang($prefix . '.fields.city')
            @if(isset($required['city']) && $required['city'])
                <i class="required-field">*</i>
            @endif
        </label>
        <div class="{{ $field_div_class }}">
            {!! Form::text($relation . '[city]', null, [
            'class' => 'form-control city',
             isset($required['city']) && $required['city'] ? 'required' : ''
             ]) !!}
            {!! Form::errorMsg($relation_error . 'city', $errors) !!}
        </div>
    </div>
    @php
        if ($model->address && $model->address->country_id){
            $country = $model->address->country;
            $selectedCountryId = $country->id;
            $selectedCountry = [$country->id => $country->title_fr];
        } else {
            $france = \App\Models\Common\Country::where('iso_alpha_2', 'FR')->first();
            $selectedCountryId = null;
            $selectedCountry = [];
    
            if($france)
            {
                $selectedCountryId = null;
                $selectedCountry = [$france->id => $france->title_fr];;
            }
        }
    @endphp
    
    @include('app.includes.form.select2', [
        'select_id'         => 'country_id',
        'label'             => $prefix . '.fields.country',
        'required'          => isset($required['country']) && $required['country'] ? true : false,
        'field'             => $relation . '[country_id]',
        'field_error'       => $relation_error . 'country_id',
        'values'            => $selectedCountry,
        'selected_value'    => $selectedCountryId,
        'label_class'       => $label_class,
        'div_class'         => $field_div_class,
        'form_group_class'  => $form_group_class,
        'class'             => 'country'
    ])
    @if(isset($display_lat_lng) && $display_lat_lng)
        <div class="form-group {{$form_group_class}}">
            <div class="{{$label_class}}"></div>
            <div class="{{$field_div_class}}">
                <a href="#" class="btn btn-primary btn-rounded js-search-address"><i class="fas fa-search"></i> @lang('addresses.buttons.search_gps')</a>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="form-group {{$form_group_class}} {!! Form::hasError('address.latitude', $errors) !!}">
            <label class="{{$label_class}} control-label">@lang($prefix . '.fields.latitude')
                @if(isset($required['latitude']) && $required['latitude'])
                    <i class="required-field">*</i>
                @endif
            </label>
            <div class="{{ $field_div_class }}">
                {!! Form::text($relation . '[latitude]', null, [
                'id'    => 'latitude',
                'class' => 'form-control',
                 isset($required['latitude']) && $required['latitude'] ? 'required' : ''
                ]) !!}
                {!! Form::errorMsg('address.latitude', $errors) !!}
            </div>
        </div>
        <div class="form-group {{$form_group_class}} {!! Form::hasError('address.longitude', $errors) !!}">
            <label class="{{$label_class}} control-label">@lang($prefix . '.fields.longitude')
                @if(isset($required['longitude']) && $required['longitude'])
                    <i class="required-field">*</i>
                @endif
            </label>
            <div class="{{ $field_div_class }}">
                {!! Form::text($relation . '[longitude]', null, [
                'id'    => 'longitude',
                'class' => 'form-control',
                 isset($required['longitude']) && $required['longitude'] ? 'required' : ''
                ]) !!}
                {!! Form::errorMsg('address.longitude', $errors) !!}
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="alert alert-info"><i class="fas fa-map-marker-alt"></i> @lang('addresses.labels.map')</div>
        <div id="gmap" style="height: 500px;"></div>
    @endif--}}
</div>

@push('scripts')

    @if(isset($display_lat_lng) && $display_lat_lng)
        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key={{config('app.gmap_api_key')}}&callback=AddressableForm.initMap">
        </script>
    @endif

    {!! Html::script('/app/js/addresses/form.js') !!}
@endpush
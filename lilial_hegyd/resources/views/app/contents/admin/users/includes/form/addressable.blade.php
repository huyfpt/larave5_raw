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
    <div class="form-group {{$form_group_class}} {!! Form::hasError($relation_error . 'city', $errors) !!}">
        <label class="{{$label_class}} control-label">@lang($prefix . '.fields.city')
            @if(isset($required['city']) && $required['city'])
                <i class="required-field">*</i>
            @endif
        </label>
        <div class="{{ $field_div_class }}">
            <select class="form-control" id="user_city" name="address[city]" required="">
                @if(!empty($cities))
                    @if(!empty($city))
                        <option value="{{$city}}">{{$city}}</option>
                    @endif
                    @foreach($cities as $item)
                        <option value="{{$item}}">{{$item}}</option>
                    @endforeach
                @endif
            </select>
            {!! Form::errorMsg($relation_error . 'city', $errors) !!}
        </div>
    </div>
</div>

@push('scripts')
    {!! Html::script('/app/js/addresses/form.js') !!}
@endpush
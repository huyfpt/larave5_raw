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
    <div class="form-group {{$form_group_class}} {!! Form::hasError($relation_error . 'zip', $errors) !!}">
        <label class="{{$label_class}} control-label">@lang($prefix . '.fields.zip')
            @if(isset($required['zip']) && $required['zip'])
                <i class="required-field">*</i>
            @endif
        </label>
        <div class="{{ $field_div_class }}">
            <select class="form-control" id="client_zip" name="address[zip]" required="">
                @if(!empty($post_code))
                    @if(!empty($zip))
                        <option selected="" value="{{$zip}}">{{$zip}}</option>
                    @endif
                    @foreach($post_code as $item)
                        <option value="{{$item}}">{{$item}}</option>
                    @endforeach
                @endif
            </select>
            {!! Form::errorMsg($relation_error . 'zip', $errors) !!}
        </div>
    </div>
    
</div>

@push('scripts')
    {!! Html::script('/app/js/addresses/form.js') !!}
@endpush
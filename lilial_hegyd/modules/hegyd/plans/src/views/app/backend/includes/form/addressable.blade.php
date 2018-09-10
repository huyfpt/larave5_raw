@php
    !isset($prefix) ? $prefix = 'addresses' : '';
    !isset($relation) ? $relation = 'address' : '';
    !isset($relation_error) ? $relation_error = 'address' : '';
    !isset($label_class) ? $label_class='col-md-2' : null;
    !isset($field_div_class) ? $field_div_class = 'col-md-10' : '';
    !isset($form_group_class) ? $form_group_class='' : null;

    if(strstr($_SERVER['REQUEST_URI'], 'plans') == true)
    {
        $zip = $model->address->zip;
    } else
    {
        $zip = $model->address->zip;
    }
@endphp
<div class="addressable_form">
    <div class="form-group {{$form_group_class}} {!! Form::hasError($relation_error . 'zip', $errors) !!}">
        <label class="{{$label_class}} control-label">@lang($prefix . '.fields.zip')
            <i class="required-field">*</i>
        </label>
        @php
            $post_code[$zip] = $zip;
        @endphp
        <div class="{{ $field_div_class }}">
            <select class="form-control" id="plan_zip" name="address[zip]" required="">
                @if(!empty($post_code))
                    @foreach($post_code as $item)
                        <option @if($item == $zip) selected @endif value="{{$item}}">{{$item}}</option>
                    @endforeach
                @endif
            </select>
            {{--{!! Form::select($relation . '[zip]', $post_code, $zip, [
            'class' => 'form-control', 'required', 'id' => 'plan_zip']) !!}--}}
            {!! Form::errorMsg('zip', $errors) !!}
        </div>
    </div>
</div>

@push('scripts')
    {!! Html::script('/app/js/addresses/form.js') !!}
@endpush
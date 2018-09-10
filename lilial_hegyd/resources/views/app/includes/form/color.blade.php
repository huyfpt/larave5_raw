@php
    if(!isset($field)){
        $field = 'color';
    }
    if(!isset($value)){
        $value = '';
    }
    if(!isset($label_class)){
        $label_class='col-md-2';
    }
    if(!isset($div_class)){
        $div_class='col-md-2';
    }
@endphp

<div class="form-group {!! Form::hasError($field, $errors) !!}"
     data-field="{{$field}}">
    <div class="{{$label_class}}">
        <label class="control-label"
               for="{{$field}}">@lang(isset($label) ? $label : 'app.color')
            @if(isset($required) && $required)
                <span class="required"> * </span>
            @endif
        </label>
        @if(isset($description))
            <br>
            <span class="recommended">{!! $description !!}</span>
        @endif
    </div>
    <div class="{{$div_class}}">
        @php
            $data_file = [
                'class' => 'form-control',
                isset($required) && $required ? 'required' : '',
            ];
        @endphp

        <div class="input-group colorpicker-component">
            {!! Form::text($field, $value, $data_file) !!}
            <span class="input-group-addon"><i></i></span>
        </div>
        {!!  Form::errorMsg($field, $errors)  !!}
    </div>
</div>

@push('stylesheets')
{!! Html::style('/vendor/bower/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') !!}
@endpush

@push('scripts')
{!! Html::script('/vendor/bower/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') !!}
{!! Html::script('/app/js/colorpicker.js') !!}
@endpush

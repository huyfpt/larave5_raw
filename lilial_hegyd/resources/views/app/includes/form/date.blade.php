@php

    if(!isset($format_picker))
    {
        $format_picker = 'dd/mm/yyyy';
    }
    if(!isset($format))
    {
        $format = 'd/m/Y';
    }
    if(!isset($value)){
        $value = $model->{$field} ? $model->{$field}->format($format) : null;
    }else{
        $value = $value->format($format);
    }

    if(!isset($label_class))
    {
        $label_class='col-md-2';
    }

    if(!isset($div_class))
    {
        $div_class='col-md-10';
    }

    !isset($allow_clear) ? $allow_clear = false : '';

    $data = [
        'readonly',
        'class' => 'form-control',
        isset($required) && $required ? 'required' : '',
    ];
@endphp

<div class="form-group {!! Form::hasError($field, $errors) !!}"
     data-field="{{$field}}">
    <div class="{{$label_class}}">
        <label class="control-label"
               for="{{$field}}">@lang(isset($label) ? $label : 'app.date')
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
        <div class="input-group date datepicker not-init"
             data-format="{{$format_picker}}"
            data-allow-clear="{{$allow_clear}}">
            <span class="input-group-btn">
                <button class="btn default" type="button">
                    <i class="fas fa-calendar-alt"></i>
                </button>
            </span>
            {!! Form::text($field, $value, $data) !!}
        </div>
        {!!  Form::errorMsg($field, $errors)  !!}
    </div>
</div>

@push('stylesheets')
    {!! Html::style('/vendor/bower/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') !!}
@endpush
@push('scripts')
    {!! Html::script('/vendor/bower/moment/min/moment.min.js') !!}
    {!! Html::script('/vendor/bower/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') !!}
    {!! Html::script('/vendor/bower/bootstrap-datepicker/dist/locales/bootstrap-datepicker.fr.min.js') !!}

    {!! Html::script('/app/js/date.js') !!}
@endpush
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

    $data = [
        'readonly',
        'class' => 'form-control',
        isset($required) && $required ? 'required' : '',
    ];

@endphp

<div class="form-group {!! Form::hasError($field, $errors) !!}" data-field="{{$field}}">
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
    <div class="{{$div_class}} {{Form::hasError($field, $errors)}}">
        <div class="input-group date datetimepicker not-init">
            <span class="input-group-addon">
                <i class="fas fa-calendar-alt"></i>
            </span>
            {!! Form::text($field, $value, $data) !!}
        </div>
        {!!  Form::errorMsg($field, $errors)  !!}
    </div>
</div>

@push('stylesheets')
{!! Html::style('/vendor/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') !!}
@endpush
@push('scripts')
{!! Html::script('/vendor/bower/moment/min/moment.min.js') !!}
{!! Html::script('/vendor/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') !!}
{!! Html::script('/vendor/bower/moment/locale/fr.js') !!}

{!! Html::script('/app/js/datetime.js') !!}
@endpush
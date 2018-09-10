@php

    if(!isset($required))
        $required = false;

    if(!isset($fieldError))
        $fieldError = $field;

    if(!isset($fieldId))
        $fieldId = $field;

    if(!isset($fieldLabel))
        $fieldLabel = $field;

    if(!isset($fieldClass))
        $fieldClass = '';

    if(!isset($fieldValue))
        $fieldValue = null;

    if(!isset($labelClass))
        $labelClass = 'col-md-2';

    if(!isset($divClass))
        $divClass = 'col-md-12';

    $fieldOptions = [
        'id'    => $fieldId,
        'class' => "form-control summernoteable $fieldClass",
         $required ? 'required' : '',
    ];

@endphp


<div class="form-group {!! Form::hasError($fieldError, $errors) !!}">
    <label class="control-label {{$labelClass}}" for="{!! $field !!}">
        @lang($fieldLabel)
        @if($required)
            <i class="required-field">*</i>
        @endif
    </label>
    <div class="{{$divClass}}">
        {!!
            Form::textarea(
                $field,
                $fieldValue,
                $fieldOptions
            )
        !!}
        {!! Form::errorMsg($fieldError, $errors) !!}
    </div>
</div>


@push('stylesheets')
    {!! Html::style('/vendor/bower/summernote/dist/summernote.css') !!}
@endpush

@push('scripts')
    {!! Html::script('/vendor/bower/summernote/dist/summernote.min.js') !!}
    {!! Html::script('/vendor/bower/summernote/lang/summernote-fr-FR.js') !!}
@endpush
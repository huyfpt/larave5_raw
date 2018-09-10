@php
    if(!isset($field_error))
    {
        $field_error = $field;
    }

    if(!isset($required))
    {
        $required = false;
    }

    if(!isset($select_id))
    {
        $select_id='';
    }

    if(!isset($class))
    {
        $class='';
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
        'id'    => $select_id,
        'class' => "form-control select2 $class",
         $required ? 'required' : '',
         isset($multiple) ? 'multiple' : ''
    ];
    if (isset($placeholder))
        $data['data-placeholder'] = $placeholder;
@endphp

<div class="form-group {!! Form::hasError($field_error, $errors) !!}">
    <label class="{{$label_class}} control-label" >@lang($label)
        @if($required)
            <i class="required-field">*</i>
        @endif
    </label>
    <div class="{{$div_class}}">
        {!!
            Form::select(
                $field,
                $values,
                $selected_value,
                $data
            )
        !!}
        {!! Form::errorMsg($field_error, $errors) !!}
    </div>
</div>

@push('stylesheets')
{!! Html::style('/vendor/bower/select2/dist/css/select2.min.css') !!}
@endpush

@push('scripts')
{!! Html::script('/vendor/bower/select2/dist/js/select2.full.min.js') !!}
{!! Html::script('/vendor/bower/select2/dist/js/i18n/fr.js') !!}
@endpush
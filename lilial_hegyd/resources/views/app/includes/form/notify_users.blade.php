@php
    !isset($field) ? $field = 'notify_users' :'';
    !isset($label) ? $label = 'app.fields.notify_users' : '';
    !isset($label_div_class) ? $label_div_class = 'col-md-2' : '';
    !isset($field_div_class) ? $field_div_class = 'col-md-10' : '';

@endphp
<div class="form-group {!! Form::hasError($field, $errors) !!}">
    <div class="{{$label_div_class}}">
        <label class="control-label">@lang($label)</label>
    </div>
    <div class="{{$field_div_class}}">
        {!! Form::checkbox($field, 1, null, ['class' => 'switcheryable']) !!}
        {!! Form::errorMsg($field, $errors) !!}
    </div>
</div>
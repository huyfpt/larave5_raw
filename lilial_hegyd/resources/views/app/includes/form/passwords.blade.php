@php

    if(!isset($field)){
        $field = 'password';
    }

    if(!isset($field_confirm)){
        $field_confirm = 'password_confirmation';
    }

    if(!isset($error_field)){
        $error_field = 'password';
    }

    if(!isset($error_field_confirm)){
        $error_field_confirm = 'password_confirmation';
    }

    if (! isset($required) || ($required && $model->exists))
    {
        $required = false;
    }
@endphp

<div class="form-group {!! Form::hasError($error_field, $errors) !!}">
    <label class="col-md-2 control-label"
           for="{{$field}}">@lang(isset($label) ? $label : 'app.password')
        @if(isset($required) && $required)
            <span class="required"> * </span>
        @endif
    </label>
    <div class="col-md-9">
        <div class="input-group">
            {!! Form::password($field, [
            'class' => 'form-control',
            'id' => $field,
            isset($required) && $required ? 'required' : ''
            ]) !!}
            <span class="input-group-btn">
                <a class="btn btn-primary generate_password" type="button">@lang('app.buttons.generate')</a>
		    </span>
        </div>
        <div class="alert alert-info hide" id="passKey"></div>
        {!! Form::errorMsg($error_field, $errors) !!}
    </div>
</div>
@if(!isset($confirmation) || $confirmation == false)
    <div class="form-group {!! Form::hasError($error_field_confirm, $errors) !!}">
        <label class="col-md-2 control-label"
               for="{{$field_confirm}}">@lang(isset($label_confirm) ? $label_confirm : 'app.password_confirmation')
            @if(isset($required) && $required)
                <span class="required"> * </span>
            @endif
        </label>
        <div class="col-md-9">
            {!! Form::password($field_confirm, [
            'class' => 'form-control',
            'id' => $field_confirm,
            isset($required) && $required ? 'required' : ''
            ]) !!}
            {!! Form::errorMsg($error_field_confirm, $errors) !!}
        </div>
    </div>
@endif

@push('scripts')
    {!! Html::script('/app/js/passwords/generate.js') !!}
@endpush
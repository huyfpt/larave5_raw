@php
    if(!isset($field)){
        $field = 'file';
    }

    if (isset($required) && $required)
    {
        if ($model->{$field} != null && $model->{$field}->exists)
        {
            $required = false;
        }
    }

    if(!isset($label_class))
    {
        $label_class='col-md-2';
    }

    if(!isset($div_class))
    {
        $div_class='col-md-10';
    }
    !isset($field_class) ? $field_class = '' : '';
@endphp

<div class="form-group {!! Form::hasError($field, $errors) !!}" data-field="{{$field}}">
    <div class="{{$label_class}}">
        <label class="control-label"
               for="{{$field}}">@lang(isset($label) ? $label : 'app.file')
            @if(isset($required) && $required)
                <span class="required"> * </span>
            @endif
        </label>
        @if(isset($recommended_size))
            <br>
            <span class="recommended">{!! $recommended_size !!}</span>
        @endif
        @if($model->{$field})
            <a href="{{$model->{$field}->media}}" class="btn btn-default" target="_blank"><i class="fas fa-eye"></i></a>
        @endif
    </div>
    <div class="{{$div_class}}">
        @php
            $data_file = [
                'class'             => "file-loading unique-file-file-input $field_class",
                'data-show-remove'  => isset($show_remove) ? "$show_remove" : "true",

            ];
            if( isset($required) && $required)
                $data_file['required'] = true;

            if($model->exists && $model->{$field})
            {
                $data_file['data-initial-preview'] = '<i class="fas fa-file fa-4x"/>';
            }

            if(isset($allowed_format))
            {
                $data_file['data-allowed-format'] = json_encode($allowed_format);
{{--                Ok c'est tricky...--}}
                $data_file['accept'] = '.' . implode(', .', $allowed_format);
            }
        @endphp

        {!! Form::file($field, $data_file) !!}
        {!!  Form::errorMsg($field, $errors)  !!}
    </div>
</div>


@push('stylesheets')
{!! Html::style('/vendor/bower/bootstrap-fileinput/css/fileinput.min.css') !!}
@endpush
@push('scripts')
{!! Html::script('/vendor/bower/bootstrap-fileinput/js/fileinput.min.js') !!}
{!! Html::script('/vendor/bower/bootstrap-fileinput/js/locales/fr.js') !!}

{!! Html::script('/app/js/file-input.js') !!}
@endpush
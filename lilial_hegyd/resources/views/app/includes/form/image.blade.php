@php
    if(!isset($field)){
        $field = 'visual';
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
@endphp

<div class="form-group {!! Form::hasError($field, $errors) !!}" data-field="{{$field}}">
    <div class="{{$label_class}}">
        <label class="control-label"
               for="{{$field}}">@lang(isset($label) ? $label : 'app.image')
            @if(isset($required) && $required)
                <span class="required"> * </span>
            @endif
        </label>
        @if(isset($recommended_size))
            <br>
            <span class="recommended">{!! $recommended_size !!}</span>
        @endif
    </div>
    <div class="{{$div_class}}">
        @php
            $data_file = [
                'class' => 'file-loading unique-image-file-input',
                'data-show-remove' => isset($show_remove) ? $show_remove : 'true',
                isset($required) && $required ? 'required' : '',
            ];

            if(!isset($preview_src) && $model->exists && $model->{$field})
            {
                $preview_src = $model->{$field}->media;
            }

            if(isset($preview_src) && $preview_src)
            {
                $data_file['data-initial-preview'] = '<img class="file-preview-image" src="' . $preview_src . '" />';
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
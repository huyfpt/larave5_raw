@php
    if(!isset($field)){
        $field = 'visualDocument';
    }

    if (isset($required) && $required)
    {
        if ($model->{$field} != null && $model->{$field}->exists)
        {
            $required = false;
        }
    }

@endphp

<div class="form-group {!! Form::hasError($field, $errors) !!}" data-field="{{$field}}">
    <div class="col-md-2">
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
    <div class="col-md-9">
        @php
            $data_file = [
                'class' => 'file-loading unique-image-file-input',
                'data-show-remove' => isset($show_remove) ? $show_remove : 'true',
                isset($required) && $required ? 'required' : '',
                'draggable' => "true",
                'data-template' => 'pdf'
            ];

            if($model->exists && $model->{$field}) {
                $data_file['data-initial-preview'] = '<embed type="application/pdf" class="kv-preview-data" src="' . $model->{$field}->media . '" />';
            }
        @endphp

        {!! Form::file($field, $data_file) !!}

        {!!  Form::errorMsg($field, $errors)  !!}
    </div>
</div>


@push('stylesheets')
{!! Html::style('/vendor/hegyd/faqs/dependencies/bootstrap-fileinput/css/fileinput.min.css') !!}
@endpush
@push('scripts')
{!! Html::script('/vendor/hegyd/faqs/dependencies/bootstrap-fileinput/js/fileinput.min.js') !!}
{!! Html::script('/vendor/hegyd/faqs/dependencies/bootstrap-fileinput/js/locales/fr.js') !!}

{!! Html::script('/vendor/hegyd/faqs/js/file-input.js') !!}
@endpush

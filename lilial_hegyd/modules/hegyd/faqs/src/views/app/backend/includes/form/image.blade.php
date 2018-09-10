@php
    if(!isset($field)){
        $field = 'visual';
    }
    $required = true;
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
            
                <span class="required"> * </span>
            
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
            ];

            if($model->exists && $model->{$field}) {
                $data_file['data-initial-preview'] = '<img class="file-preview-image" src="' . $model->{$field}->media . '" />';
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
<script>
    $('.fileinput-remove-button').click(function(){
    $("input[name='visual']").attr("required", true)
});
$('.save-btn, .save-and-close-btn, .save-and-new-btn').click(function (e){
    var error = 0;

    $(':input[required]', '#faqs_form').each(function(){
        if($(this).val() == ''){

            error += 1;

            var name = $(this).attr('name');

            alert_error = '<ul><li><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Le champ '+ name +' est obligatoire.</font></font></li></ul>';
            if ($(this).attr('name') == 'visual') {
                var file_input = $(this).parent().parent();
                file_input.siblings('.help-block').html(alert_error);
                file_input.parent().parent().addClass('has-error');
            }
            else {
                $(this).siblings('.help-block').html(alert_error);
                $(this).parent().parent().addClass('has-error');
            }
        }
        else {
            $(this).siblings('.help-block').html('');
            $(this).parent().parent().removeClass('has-error');
        }
    });

    
    if (error != 0) {
        var message = error + '  champs ne sont pas valides. Ils sont entourés de rouge';
        toastr.error(message);
        return false;
    }

    return true;

});
</script>
@endpush

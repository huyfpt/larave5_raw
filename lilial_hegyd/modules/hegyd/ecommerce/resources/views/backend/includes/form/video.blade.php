<div class="form-group {!! Form::hasError('video_link', $errors) !!}">
    <label class="col-sm-2 control-label">@lang('slides.fields.video_link') <i class="required-field">*</i></label>
    <div class="col-md-10">
        {!! Form::text('video_link', null, ['class' => 'form-control',
                                            'placeholder' => 'exemple : http://www.youtube.com/watch?v=wnRwCQ']) !!}
        {!! Form::errorMsg('video_link', $errors) !!}
    </div>
</div>

@push('stylesheets')
    {!! Html::style('/vendor/hegyd/ecommerce/dependencies/bootstrap-fileinput/css/fileinput.min.css') !!}
@endpush
@push('scripts')
{!! Html::script('/vendor/hegyd/ecommerce/dependencies/bootstrap-fileinput/js/fileinput.min.js') !!}
{!! Html::script('/vendor/hegyd/ecommerce/dependencies/bootstrap-fileinput/js/locales/fr.js') !!}

{!! Html::script('/vendor/hegyd/ecommerce/js/file-input.js') !!}
@endpush

{!! Form::model($model, ['route' => $route, 'method' => $method, 'class' => 'form-horizontal']) !!}
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">@lang('hegyd-news::report_comment.title.contact_concerned_user')</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group {!! Form::hasError('content', $errors) !!}">
                <label class="col-md-3">
                    <label class="control-label">@lang('hegyd-news::report_comment.fields.name')</label>
                    <i class="required-field">*</i>
                </label>
                <div class="col-md-9">
                    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                    {!! Form::errorMsg('name', $errors) !!}
                </div>
            </div>
            <div class="form-group {!! Form::hasError('content', $errors) !!}">
                <label class="col-md-3">
                    <label class="control-label">@lang('hegyd-news::report_comment.fields.content')</label>
                    <i class="required-field">*</i>
                </label>
                <div class="col-md-9">
                    {!! Form::textarea('content', null, ['class' => 'form-control summernote', 'required']) !!}
                    {!! Form::errorMsg('content', $errors) !!}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('app.buttons.close')</button>
    <button type="submit" class="btn btn-primary">@lang('hegyd-news::report_comment.buttons.send')</button>
</div>
{!! Form::close() !!}

<div class="col-md-12 loading hide text-center">
    <i class="fa fa-circle-o-notch fa-spin text-danger fa-5x"></i>
</div>

@push('stylesheets')
    {!! Html::style('/vendor/hegyd/news/dependencies/summernote/dist/summernote.css') !!}
@endpush
@push('scripts')
    {!! Html::script('/vendor/hegyd/news/dependencies/summernote/dist/summernote.min.js') !!}
    {!! Html::script('/vendor/hegyd/news/dependencies/summernote/dist/lang/summernote-fr-FR.js') !!}
    {!! Html::script('/vendor/hegyd/news/dependencies/jquery-form/jquery.form.js') !!}
@endpush
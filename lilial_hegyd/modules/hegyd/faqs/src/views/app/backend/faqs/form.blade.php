@extends(config('hegyd-faqs.main_layout.backend'))

@section('title')
    {!! $title !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                {!! Form::model($model, ['route' => $route, 'method' => $method, 'class' => 'form-horizontal', 'files' => true, 'id' => 'faqs_form']) !!}
                <div class="ibox-title">
                    <h3>{!! $title !!}</h3>
                    <div class="ibox-tools">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">

                        <div class="form-group {!! Form::hasError('title', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-faqs::faqs.field.title') <i class="required-field">*</i></label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title', 'onkeyup' => 'ChangeToSlug()']) !!}
                                {!! Form::errorMsg('title', $errors) !!}
                            </div>
                        </div>

                        <div class="form-group {!! Form::hasError('slug', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-faqs::faqs.field.slug') <i class="required-field">*</i></label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::text('slug', null, ['class' => 'form-control', 'id' => 'slug', 'readonly']) !!}
                                {!! Form::errorMsg('slug', $errors) !!}
                            </div>
                        </div>
                        <div class="form-group {!! Form::hasError('content', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-faqs::faqs.field.content') <i class="required-field">*</i></label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::textarea('content', null, ['class' => 'form-control summernote', 'required']) !!}
                                {!! Form::errorMsg('content', $errors) !!}
                            </div>
                        </div>

                        <div class="form-group {!! Form::hasError('status', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-faqs::faqs.field.status')</label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::checkbox('status', 1, null, ['class' => 'switcheryable']) !!}
                                {!! Form::errorMsg('status', $errors) !!}
                            </div>
                        </div>
                        
                        <div class="form-group {!! Form::hasError('category_id', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-faqs::faqs.field.category_id') <i class="required-field">*</i></label>
                            </div>
                            <div class="col-md-8">
                                {!! Form::select('category_id', $categories, $category_selected, ['class' => 'form-control', 'required']) !!}
                                {!! Form::errorMsg('category_id', $errors) !!}
                            </div>
                            {{-- @if(Entrust::can(config('hegyd-faqs.permissions.backend.faqs_category.create')))
                                <a data-toggle="modal" data-target="#modal-category" href="" class="btn btn-primary">
                                    <i class="fa fa-plus" aria-hidden="true"></i> @lang('hegyd-faqs::faqs_categories.button.add')
                                </a>
                            @endif --}}
                        </div>
                        
                        <div class="form-group {!! Form::hasError('start_at', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-faqs::faqs.field.start_at')
                                    <i class="fa fa-info-circle" data-toggle="tooltip" title="@lang('hegyd-faqs::faqs.label.start_at')"></i>
                                </label>
                            </div>
                            <div class="col-md-10 input-group date">
                                <div class="input-group date">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                                    {!! Form::text('start_at', $model->start_at ? date('d/m/Y', strtotime($model->start_at)) : null, ['class' => 'form-control', 'readonly']) !!}
                                </div>
                                {!! Form::errorMsg('start_at', $errors) !!}
                            </div>
                        </div>
                        <div class="form-group {!! Form::hasError('end_at', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-faqs::faqs.field.end_at')
                                    <i class="fa fa-info-circle" data-toggle="tooltip" title="@lang('hegyd-faqs::faqs.label.end_at')"></i>
                                </label>
                            </div>
                            <div class="col-md-10 input-group date">
                                <div class="input-group date">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                                    {!! Form::text('end_at', $model->end_at ? date('d/m/Y', strtotime($model->end_at)) : null, ['class' => 'form-control', 'readonly']) !!}
                                </div>
                                {!! Form::errorMsg('end_at', $errors) !!}
                            </div>
                        </div>
                        @include('hegyd-faqs::backend.includes.form.image')

                        @include('hegyd-faqs::backend.includes.form.document', ['field' => 'visualDocument', 'label' => trans('hegyd-faqs::faqs.field.visual_document')])

                        <div class="form-group {!! Form::hasError('author_id', $errors) !!}">
                            <label for="author_id" class="label-control col-md-2">@lang('hegyd-faqs::faqs.field.author')</label>
                            <div class="col-md-10">
                                {!! Form::select('author_id',  $authors, $model->author ? $model->author->id : $author_selected, ['class' => 'form-control', 'required']) !!}
                                {!! Form::errorMsg('author_id', $errors) !!}
                            </div>
                        </div>

                        <div class="form-group {!! Form::hasError('meta_title', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-faqs::faqs.field.meta_title')<i class="required-field">*</i></label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::text('meta_title', null, ['class' => 'form-control']) !!}
                                {!! Form::errorMsg('meta_title', $errors) !!}
                            </div>
                        </div>
                        <div class="form-group {!! Form::hasError('meta_description', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-faqs::faqs.field.meta_description')<i class="required-field">*</i></label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::textarea('meta_description', null, ['class' => 'form-control']) !!}
                                {!! Form::errorMsg('meta_description', $errors) !!}
                            </div>
                        </div>

                        <div class="form-group {!! Form::hasError('meta_keyword', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-faqs::faqs.field.meta_keyword')</label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::text('meta_keyword', null, ['class' => 'form-control']) !!}
                                {!! Form::errorMsg('meta_keyword', $errors) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                @include('hegyd-faqs::backend.includes.form.footer',[
                    'more_actions' => [
                        [
                            'text' => trans('hegyd-faqs::faqs.button.show_page'),
                            'href' => $model->url(),
                            'target' =>'_blank',
                            'class' => 'btn-default',
                            'only_exists' => true
                        ]
                    ]
                ])
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    {{-- @include('hegyd-faqs::backend.faqs.includes.category-modal', ['category' => new \Hegyd\News\Models\NewsCategory()]) --}}
@endsection
@push('stylesheets')
    {!! Html::style('/vendor/hegyd/faqs/dependencies/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') !!}
    {!! Html::style('/vendor/hegyd/faqs/dependencies/select2/dist/css/select2.min.css') !!}
    {!! Html::style('/vendor/hegyd/faqs/dependencies/summernote/dist/summernote.css') !!}
@endpush
@push('scripts')
    {!! Html::script('/vendor/hegyd/faqs/dependencies/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') !!}
    {!! Html::script('/vendor/hegyd/faqs/dependencies/bootstrap-datepicker/dist/locales/bootstrap-datepicker.fr.min.js') !!}
    {!! Html::script('/vendor/hegyd/faqs/dependencies/select2/dist/js/select2.full.min.js') !!}
    {!! Html::script('/vendor/hegyd/faqs/dependencies/select2/dist/js/i18n/fr.js') !!}
    {!! Html::script('/vendor/hegyd/faqs/dependencies/summernote/dist/summernote.min.js') !!}
    {!! Html::script('/vendor/hegyd/faqs/dependencies/summernote/dist/lang/summernote-fr-FR.js') !!}
    {!! Html::script('/vendor/hegyd/faqs/dependencies/jquery-form/jquery.form.js') !!}
    {!! Html::script('/vendor/hegyd/faqs/js/modal.js') !!}
    {!! Html::script('/vendor/hegyd/faqs/js/faqs/form.js') !!}
    {!! Html::script('/vendor/hegyd/plans/js/plans/changetoslug.js') !!}
@endpush
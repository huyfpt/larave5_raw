@extends(config('hegyd-pages.main_layout.backend'))
@section('title')
    {!! $title !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                {!! Form::model($model, ['route' => $route, 'method' => $method, 'class' => 'form-horizontal', 'files' => true, 'id' => 'pages_form']) !!}
                <div class="ibox-title">
                    <h3>{!! $title !!}</h3>
                    <div class="ibox-tools">
                        @include('hegyd-pages::backend.includes.form.actions')
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12">

                        <div class="form-group {!! Form::hasError('status', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-pages::pages.field.status')</label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::checkbox('status', 1, null, ['class' => 'switcheryable']) !!}
                                {!! Form::errorMsg('status', $errors) !!}
                            </div>
                        </div>
                        <div class="form-group {!! Form::hasError('title', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-pages::pages.field.title') <i class="required-field">*</i></label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title', 'onkeyup' => 'ChangeToSlug()']) !!}
                                {!! Form::errorMsg('title', $errors) !!}
                            </div>
                        </div>
                        <div class="form-group {!! Form::hasError('slug', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-pages::pages.field.slug') <i class="required-field">*</i></label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::text('slug', null, ['class' => 'form-control', 'id' => 'slug', 'readonly']) !!}
                                {!! Form::errorMsg('slug', $errors) !!}
                            </div>
                        </div>
                        <div class="form-group {!! Form::hasError('content', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-pages::pages.field.content') <i class="required-field">*</i></label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::textarea('content', null, ['class' => 'form-control summernote']) !!}
                                {!! Form::errorMsg('content', $errors) !!}
                            </div>
                        </div>
                        <div class="form-group {!! Form::hasError('description', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-pages::pages.field.description')
                            </div>
                            <div class="col-md-10">
                                {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                                {!! Form::errorMsg('description', $errors) !!}
                            </div>
                        </div>
                        <div class="form-group {!! Form::hasError('meta_title', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-pages::pages.field.meta_title')</label><i class="required-field">*</i></label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::text('meta_title', null, ['class' => 'form-control']) !!}
                                {!! Form::errorMsg('meta_title', $errors) !!}
                            </div>
                        </div>


                        <div class="form-group {!! Form::hasError('meta_description', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-pages::pages.field.meta_description')</label><i class="required-field">*</i></label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::textarea('meta_description', null, ['class' => 'form-control']) !!}
                                {!! Form::errorMsg('meta_description', $errors) !!}
                            </div>
                        </div>

                        
                        <div class="form-group {!! Form::hasError('meta_keyword', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-pages::pages.field.meta_keyword')</label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::text('meta_keyword', null, ['class' => 'form-control']) !!}
                                {!! Form::errorMsg('meta_keyword', $errors) !!}
                            </div>
                        </div>

                        <div class="form-group {!! Form::hasError('meta_robots', $errors) !!}">
                            <label class="control-label col-md-2" for="meta_robots">
                                @lang('hegyd-pages::pages.field.meta_robots') 
                            </label>
                            <div class="col-md-9">
                                {!! Form::select('meta_robots',['INDEX, FOLLOW'=>'INDEX, FOLLOW',
                                'NOINDEX, FOLLOW'=> 'NOINDEX, FOLLOW',
                                'INDEX, NOFOLLOW'=> 'INDEX, NOFOLLOW',
                                'NOINDEX, NOFOLLOW'=> 'NOINDEX, NOFOLLOW'], null ,[
                                    'class' => 'form-control','required'
                                    ]) !!}
                                {!! Form::errorMsg('meta_robots', $errors) !!}
                            </div>
                        </div>

                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                @include('hegyd-pages::backend.includes.form.footer')
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection
@push('stylesheets')
    {!! Html::style('/vendor/hegyd/pages/dependencies/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') !!}
    {!! Html::style('/vendor/hegyd/pages/dependencies/select2/dist/css/select2.min.css') !!}
    {!! Html::style('/vendor/hegyd/pages/dependencies/summernote/dist/summernote.css') !!}
@endpush
@push('scripts')
    {!! Html::script('/vendor/hegyd/pages/dependencies/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') !!}
    {!! Html::script('/vendor/hegyd/pages/dependencies/bootstrap-datepicker/dist/locales/bootstrap-datepicker.fr.min.js') !!}
    {!! Html::script('/vendor/hegyd/pages/dependencies/select2/dist/js/select2.full.min.js') !!}
    {!! Html::script('/vendor/hegyd/pages/dependencies/select2/dist/js/i18n/fr.js') !!}
    {!! Html::script('/vendor/hegyd/pages/dependencies/summernote/dist/summernote.min.js') !!}
    {!! Html::script('/vendor/hegyd/pages/dependencies/summernote/dist/lang/summernote-fr-FR.js') !!}
    {!! Html::script('/vendor/hegyd/pages/dependencies/jquery-form/jquery.form.js') !!}
    {!! Html::script('/vendor/hegyd/pages/js/modal.js') !!}
    {!! Html::script('/vendor/hegyd/pages/js/pages/form.js') !!}
    {!! Html::script('/vendor/hegyd/pages/js/pages/changetoslug.js') !!}
    {!! Html::script('/vendor/hegyd/pages/js/pages/validate.js') !!}
@endpush
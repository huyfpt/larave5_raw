@extends(config('hegyd-seos.main_layout.backend'))
@section('title')
    {!! $title !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                {!! Form::model($model, ['route' => $route, 'method' => $method, 'class' => 'form-horizontal', 'files' => true]) !!}
                <div class="ibox-title">
                    <h3>{!! $title !!}</h3>
                    <div class="ibox-tools">
                        @include('hegyd-seos::backend.includes.form.actions')
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12">

                        <div class="form-group {!! Form::hasError('active', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-seos::seo_url_redirects.field.active')</label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::checkbox('active', 1, null, ['class' => 'switcheryable']) !!}
                                {!! Form::errorMsg('active', $errors) !!}
                            </div>
                        </div>
                        
                        <div class="form-group {!! Form::hasError('new_url', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-seos::seo_url_redirects.field.new_url')</label><i class="required-field">*</i></label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::text('new_url', null, ['class' => 'form-control']) !!}
                                {!! Form::errorMsg('new_url', $errors) !!}
                            </div>
                        </div>
                        <div class="form-group {!! Form::hasError('old_url', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-seos::seo_url_redirects.field.old_url')</label><i class="required-field">*</i></label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::text('old_url', null, ['class' => 'form-control']) !!}
                                {!! Form::errorMsg('old_url', $errors) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                @include('hegyd-seos::backend.includes.form.footer')
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection
@push('stylesheets')
    {!! Html::style('/vendor/hegyd/seos/dependencies/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') !!}
    {!! Html::style('/vendor/hegyd/seos/dependencies/select2/dist/css/select2.min.css') !!}
    {!! Html::style('/vendor/hegyd/seos/dependencies/summernote/dist/summernote.css') !!}
@endpush
@push('scripts')
    {!! Html::script('/vendor/hegyd/seos/dependencies/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') !!}
    {!! Html::script('/vendor/hegyd/seos/dependencies/bootstrap-datepicker/dist/locales/bootstrap-datepicker.fr.min.js') !!}
    {!! Html::script('/vendor/hegyd/seos/dependencies/select2/dist/js/select2.full.min.js') !!}
    {!! Html::script('/vendor/hegyd/seos/dependencies/select2/dist/js/i18n/fr.js') !!}
    {!! Html::script('/vendor/hegyd/seos/dependencies/summernote/dist/summernote.min.js') !!}
    {!! Html::script('/vendor/hegyd/seos/dependencies/summernote/dist/lang/summernote-fr-FR.js') !!}
    {!! Html::script('/vendor/hegyd/seos/dependencies/jquery-form/jquery.form.js') !!}
    {!! Html::script('/vendor/hegyd/seos/js/modal.js') !!}
    {!! Html::script('/vendor/hegyd/seos/js/seos/form.js') !!}
@endpush
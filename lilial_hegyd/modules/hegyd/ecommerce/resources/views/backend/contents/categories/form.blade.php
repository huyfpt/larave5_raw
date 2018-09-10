@extends(config('hegyd-ecommerce.main_layout.backend'))

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
                        @include('hegyd-ecommerce::backend.includes.form.actions')
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">

                        <div class="form-group {!! Form::hasError('active', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-ecommerce::products.fields.active')</label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::checkbox('active', 1, null, ['class' => 'switcheryable']) !!}
                                {!! Form::errorMsg('active', $errors) !!}
                            </div>
                        </div>
                        <div class="form-group {!! Form::hasError('name', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-ecommerce::products.fields.name') <i class="required-field">*</i></label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                                {!! Form::errorMsg('name', $errors) !!}
                            </div>
                        </div>
                        <div class="form-group {!! Form::hasError('parent_id', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-ecommerce::categories.fields.parent_category')</label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::select('parent_id', $tree_category, $parent_id, ['class' => 'form-control']) !!}
                                {!! Form::errorMsg('parent_id', $errors) !!}
                            </div>
                        </div>
                        <div class="form-group {!! Form::hasError('description', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-ecommerce::products.fields.description') <i class="required-field">*</i></label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::textarea('description', null, ['class' => 'form-control summernote', 'required']) !!}
                                {!! Form::errorMsg('description', $errors) !!}
                            </div>
                        </div>

                        <div class="form-group {!! Form::hasError('select_site', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-ecommerce::categories.fields.select_site') <i class="required-field">*</i></label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::text('select_site', null, ['class' => 'form-control', 'required']) !!}
                                {!! Form::errorMsg('select_site', $errors) !!}
                            </div>
                        </div>
                        <div class="form-group {!! Form::hasError('trade', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-ecommerce::categories.fields.trade') <i class="required-field">*</i></label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::text('trade', null, ['class' => 'form-control', 'required']) !!}
                                {!! Form::errorMsg('trade', $errors) !!}
                            </div>
                        </div>
                        <div class="form-group {!! Form::hasError('accroche', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-ecommerce::categories.fields.accroche') <i class="required-field">*</i></label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::text('accroche', null, ['class' => 'form-control', 'required']) !!}
                                {!! Form::errorMsg('accroche', $errors) !!}
                            </div>
                        </div>
                        <hr/>

                        {{-- SEO --}}
                        <div class="form-group {!! Form::hasError('meta_title', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-ecommerce::categories.fields.meta_title') <i class="required-field">*</i></label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::text('meta_title', null, ['class' => 'form-control', 'required']) !!}
                                {!! Form::errorMsg('meta_title', $errors) !!}
                            </div>
                        </div>
                        <div class="form-group {!! Form::hasError('meta_description', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-ecommerce::categories.fields.meta_description') <i class="required-field">*</i></label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::textarea('meta_description', null, ['class' => 'form-control', 'required']) !!}
                                {!! Form::errorMsg('meta_description', $errors) !!}
                            </div>
                        </div>
                        <div class="form-group {!! Form::hasError('meta_keywords', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-ecommerce::categories.fields.meta_keywords')</label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::text('meta_keywords', null, ['class' => 'form-control']) !!}
                                {!! Form::errorMsg('meta_keywords', $errors) !!}
                            </div>
                        </div>
                        <div class="form-group {!! Form::hasError('meta_robots', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-ecommerce::categories.fields.meta_robots')</label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::select('meta_robots', config('hegyd-ecommerce.meta_robots'), $model->meta_robots, ['class' => 'form-control']) !!}
                                {!! Form::errorMsg('meta_robots', $errors) !!}
                            </div>
                        </div>

                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                @include('hegyd-ecommerce::backend.includes.form.footer')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@push('stylesheets')
{!! Html::style('/vendor/hegyd/ecommerce/dependencies/summernote/dist/summernote.css') !!}
@endpush
@push('scripts')
{!! Html::script('/vendor/hegyd/ecommerce/dependencies/summernote/dist/summernote.min.js') !!}
{!! Html::script('/vendor/hegyd/ecommerce/dependencies/summernote/dist/lang/summernote-fr-FR.js') !!}
{!! Html::script('/vendor/hegyd/ecommerce/js/categories/form.js') !!}
@endpush
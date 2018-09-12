@extends(config('hegyd-plans.main_layout.backend'))

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
                        @include('hegyd-plans::backend.includes.form.actions')
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group {!! Form::hasError('active', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-plans::plans_categories.field.active')</label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::checkbox('active', 1, null, ['class' => 'switcheryable']) !!}
                                {!! Form::errorMsg('active', $errors) !!}
                            </div>
                        </div>
                        <div class="form-group {!! Form::hasError('parent_id', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-plans::plans_categories.field.parent_id') <i class="required-field">*</i></label>
                            </div>
                            @php
                                unset($categories[$model->id]);
                                $childCategory = Hegyd\Plans\Models\PlansCategory::where('parent_id', '<>', 0)->pluck('id');
                                foreach($childCategory as $item)
                                {
                                    unset($categories[$item]);
                                }
                            @endphp
                            <div class="col-md-10">
                                {!! Form::select('parent_id', $categories, $category_selected, ['class' => 'form-control select2', 'required']) !!}
                                {!! Form::errorMsg('parent_id', $errors) !!}
                            </div>
                        </div>
                        <div class="form-group {!! Form::hasError('name', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-plans::plans_categories.field.name') <i class="required-field">*</i></label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                                {!! Form::errorMsg('name', $errors) !!}
                            </div>
                        </div>
                        <!-- @include('hegyd-plans::backend.includes.form.image') -->
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                @include('hegyd-plans::backend.includes.form.footer')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@push('stylesheets')
    {!! Html::style('/vendor/hegyd/plans/dependencies/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') !!}
    {!! Html::style('/vendor/hegyd/plans/dependencies/select2/dist/css/select2.min.css') !!}
    {!! Html::style('/vendor/hegyd/plans/dependencies/summernote/dist/summernote.css') !!}
@endpush
@push('scripts')
    {!! Html::script('/vendor/hegyd/plans/dependencies/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') !!}
    {!! Html::script('/vendor/hegyd/plans/dependencies/bootstrap-datepicker/dist/locales/bootstrap-datepicker.fr.min.js') !!}
    {!! Html::script('/vendor/hegyd/plans/dependencies/select2/dist/js/select2.full.min.js') !!}
    {!! Html::script('/vendor/hegyd/plans/dependencies/select2/dist/js/i18n/fr.js') !!}
    {!! Html::script('/vendor/hegyd/plans/dependencies/summernote/dist/summernote.min.js') !!}
    {!! Html::script('/vendor/hegyd/plans/dependencies/summernote/dist/lang/summernote-fr-FR.js') !!}
    {!! Html::script('/vendor/hegyd/plans/dependencies/jquery-form/jquery.form.js') !!}
    <!-- {!! Html::script('/vendor/hegyd/plans/js/plans/form.js') !!} -->
@endpush
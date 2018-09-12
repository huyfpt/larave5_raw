<div class="white-box">
    <div class="form-group {!! Form::hasError('active', $errors) !!}">
        <div class="col-md-2">
            <label class="control-label">@lang('hegyd-plans::plans.field.active')</label>
        </div>
        <div class="col-md-10">
            {!! Form::checkbox('active', 1, null, ['class' => 'switcheryable']) !!}
            {!! Form::errorMsg('active', $errors) !!}
        </div>
    </div>
    <div class="form-group {!! Form::hasError('avantage', $errors) !!}">
        <div class="col-md-2">
            <label class="control-label">@lang('hegyd-plans::plans.field.avantage')</label>
        </div>
        <div class="col-md-10">
            {!! Form::checkbox('avantage', 1, null, ['class' => 'switcheryable']) !!}
            {!! Form::errorMsg('avantage', $errors) !!}
        </div>
    </div>
    <div class="form-group {!! Form::hasError('visibility', $errors) !!}">
        <div class="col-md-2">
            <label class="control-label">@lang('hegyd-plans::plans.field.visibility')</label>
        </div>
        <div class="col-md-10">
            @php
                $value = !empty($model->visibility) ? $model->visibility : null;
                $checked = ($value == 0) ? 'checked' : '';
            @endphp
            {!! Form::checkbox('visibility', $value, $checked, ['class' => 'switcheryable']) !!}
            {!! Form::errorMsg('visibility', $errors) !!}
        </div>
    </div>
    <div class="form-group {!! Form::hasError('category_id', $errors) !!}">
        <div class="col-md-2">
            <label class="control-label">@lang('hegyd-plans::plans.field.category_id') <i class="required-field">*</i></label>
        </div>
        <div class="col-md-8">
            {!! Form::select('category_id', $categories, $category_selected, ['class' => 'form-control', 'required']) !!}
            {!! Form::errorMsg('category_id', $errors) !!}
        </div>
        @if(Entrust::can(config('hegyd-plans.permissions.backend.plans_category.create')))
            <a data-toggle="modal" data-target="#modal-category" href="" class="btn btn-primary" style="padding: 8px 12px">
                <i class="fa fa-plus" aria-hidden="true"></i> 
            </a>
        @endif
    </div>
    <div class="form-group {!! Form::hasError('title', $errors) !!}">
        <div class="col-md-2">
            <label class="control-label">@lang('hegyd-plans::plans.field.title') <i class="required-field">*</i></label>
        </div>
        <div class="col-md-10">
            {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title', 'onkeyup' => 'ChangeToSlug()', 'required']) !!}
            {!! Form::errorMsg('title', $errors) !!}
        </div>
    </div>
    <div class="form-group {!! Form::hasError('slug', $errors) !!}">
        <div class="col-md-2">
            <label class="control-label">@lang('hegyd-plans::plans.field.slug') <i class="required-field">*</i></label>
        </div>
        <div class="col-md-10">
            {!! Form::text('slug', null, ['class' => 'form-control', 'id' => 'slug', 'readonly', 'required']) !!}
            {!! Form::errorMsg('slug', $errors) !!}
        </div>
    </div>
    <div class="form-group {!! Form::hasError('url', $errors) !!}">
        <div class="col-md-2">
            <label class="control-label">@lang('hegyd-plans::plans.field.url')</label>
        </div>
        <div class="col-md-10">
            {!! Form::text('url', null, ['class' => 'form-control']) !!}
            {!! Form::errorMsg('url', $errors) !!}
        </div>
    </div>
    <div class="form-group {!! Form::hasError('content', $errors) !!}">
        <div class="col-md-2">
            <label class="control-label">@lang('hegyd-plans::plans.field.content') <i class="required-field">*</i></label>
        </div>
        <div class="col-md-10">
            {!! Form::textarea('content', null, ['class' => 'form-control summernote', 'required']) !!}
            {!! Form::errorMsg('content', $errors) !!}
        </div>
    </div>
</div>

<div class="white-box">
    <h3 class="box-title">@lang('hegyd-plans::plans.subtitle.address')</h3>
    @include('hegyd-plans::backend.includes.form.addressable', ['field_div_class' => 'col-md-9'])
</div>
<div class="white-box">
    <h3 class="box-title">@lang('hegyd-plans::plans.subtitle.date')</h3>
    <div class="form-group {!! Form::hasError('start_at', $errors) !!}">
        <div class="col-md-2">
            <label class="control-label">@lang('hegyd-plans::plans.field.start_at')
                <i class="fa fa-info-circle" data-toggle="tooltip" title="@lang('hegyd-plans::plans.label.start_at')"></i>
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
            <label class="control-label">@lang('hegyd-plans::plans.field.end_at')
                <i class="fa fa-info-circle" data-toggle="tooltip" title="@lang('hegyd-plans::plans.label.end_at')"></i>
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
</div>


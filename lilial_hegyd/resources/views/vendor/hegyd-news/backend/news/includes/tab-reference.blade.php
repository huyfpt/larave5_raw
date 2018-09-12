<div class="white-box">
    <div class="form-group {!! Form::hasError('active', $errors) !!}">
        <div class="col-md-2">
            <label class="control-label">@lang('hegyd-news::news.field.active')</label>
        </div>
        <div class="col-md-10">
            {!! Form::checkbox('active', 1, null, ['class' => 'switcheryable']) !!}
            {!! Form::errorMsg('active', $errors) !!}
        </div>
    </div>
    <div class="form-group {!! Form::hasError('visibility', $errors) !!}">
        <div class="col-md-2">
            <label class="control-label">@lang('hegyd-news::news.field.visibility')</label>
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
    <!-- <div class="form-group {!! Form::hasError('display_on_slider', $errors) !!}">
        <div class="col-md-2">
            <label class="control-label">@lang('hegyd-news::news.field.display_on_slider')</label>
        </div>
        <div class="col-md-10">
            {!! Form::checkbox('display_on_slider', true, null, ['class' => 'switcheryable']) !!}
            {!! Form::errorMsg('display_on_slider', $errors) !!}
        </div>
    </div>
    @if(config('hegyd-news.enable_comment'))
        <div class="form-group {!! Form::hasError('enable_comment', $errors) !!}">
            <div class="col-md-2">
                <label class="control-label">@lang('hegyd-news::news.field.enable_comment')</label>
            </div>
            <div class="col-md-10">
                {!! Form::checkbox('enable_comment', 1, null, ['class' => 'switcheryable']) !!}
                {!! Form::errorMsg('enable_comment', $errors) !!}
            </div>
        </div>
    @endif -->
    <div class="form-group {!! Form::hasError('category_id', $errors) !!}">
        <div class="col-md-2">
            <label class="control-label">@lang('hegyd-news::news.field.category_id') <i class="required-field">*</i></label>
        </div>
        <div class="col-md-8">
            {!! Form::select('category_id', $categories, $category_selected, ['class' => 'form-control']) !!}
            {!! Form::errorMsg('category_id', $errors) !!}
        </div>
        @if(Entrust::can(config('hegyd-news.permissions.backend.news_category.create')))
            <a data-toggle="modal" data-target="#modal-category" href="" class="btn btn-primary" style="padding: 8px 12px">
                <i class="fa fa-plus" aria-hidden="true"></i> 
            </a>
        @endif
    </div>
    <div class="form-group {!! Form::hasError('name', $errors) !!}">
        <div class="col-md-2">
            <label class="control-label">@lang('hegyd-news::news.field.name') <i class="required-field">*</i></label>
        </div>
        <div class="col-md-10">
            {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'onkeyup' => 'ChangeToSlug()', 'required']) !!}
            {!! Form::errorMsg('name', $errors) !!}
        </div>
    </div>
    <div class="form-group {!! Form::hasError('slug', $errors) !!}">
        <div class="col-md-2">
            <label class="control-label">@lang('hegyd-news::news.field.slug') <i class="required-field">*</i></label>
        </div>
        <div class="col-md-10">
            {!! Form::text('slug', null, ['class' => 'form-control', 'id' => 'slug', 'readonly', 'required']) !!}
            {!! Form::errorMsg('slug', $errors) !!}
        </div>
    </div>
    <div class="form-group {!! Form::hasError('content', $errors) !!}">
        <div class="col-md-2">
            <label class="control-label">@lang('hegyd-news::news.field.content') <i class="required-field">*</i></label>
        </div>
        <div class="col-md-10">
            {!! Form::textarea('content', null, ['class' => 'form-control summernote', 'required']) !!}
            {!! Form::errorMsg('content', $errors) !!}
        </div>
    </div>
</div>

<div class="white-box">
    <h3 class="box-title">@lang('hegyd-news::news.subtitle.date')</h3>
    <div class="form-group {!! Form::hasError('start_at', $errors) !!}">
        <div class="col-md-2">
            <label class="control-label">@lang('hegyd-news::news.field.start_at')
                <i class="fa fa-info-circle" data-toggle="tooltip" title="@lang('hegyd-news::news.label.start_at')"></i>
            </label>
        </div>
        <div class="col-md-10 input-group date">
            <div class="input-group date">
                <span class="input-group-btn">
                    <button class="btn default" type="button">
                        <i class="fa fa-calendar"></i>
                    </button>
                </span>
                {!! Form::text('start_at', $model->start_at ? $model->start_at->format('d/m/Y') : null, ['class' => 'form-control', 'readonly']) !!}
            </div>
            {!! Form::errorMsg('start_at', $errors) !!}
        </div>
    </div>
    <div class="form-group {!! Form::hasError('end_at', $errors) !!}">
        <div class="col-md-2">
            <label class="control-label">@lang('hegyd-news::news.field.end_at')
                <i class="fa fa-info-circle" data-toggle="tooltip" title="@lang('hegyd-news::news.label.end_at')"></i>
            </label>
        </div>
        <div class="col-md-10 input-group date">
            <div class="input-group date">
                <span class="input-group-btn">
                    <button class="btn default" type="button">
                        <i class="fa fa-calendar"></i>
                    </button>
                </span>
                {!! Form::text('end_at', $model->end_at ? $model->end_at->format('d/m/Y') : null, ['class' => 'form-control', 'readonly']) !!}
            </div>
            {!! Form::errorMsg('end_at', $errors) !!}
        </div>
    </div>
</div>


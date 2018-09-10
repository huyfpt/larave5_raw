<div class="white-box">
    <div class="form-group {!! Form::hasError('meta_title', $errors) !!}">
        <div class="col-md-2">
            <label class="control-label">@lang('hegyd-news::news.field.meta_title') <i class="required-field">*</i></label>
        </div>
        <div class="col-md-10">
            {!! Form::text('meta_title', $model->meta_title, ['class' => 'form-control', 'required']) !!}
            {!! Form::errorMsg('meta_title', $errors) !!}
        </div>
    </div>
    <div class="form-group {!! Form::hasError('meta_description', $errors) !!}">
        <div class="col-md-2">
            <label class="control-label">@lang('hegyd-news::news.field.meta_description') <i class="required-field">*</i></label>
        </div>
        <div class="col-md-10">
            {!! Form::textarea('meta_description', $model->meta_description, ['class' => 'form-control', 'required']) !!}
            {!! Form::errorMsg('meta_description', $errors) !!}
        </div>
    </div>
    <div class="form-group {!! Form::hasError('meta_keyword', $errors) !!}">
        <div class="col-md-2">
            <label class="control-label">@lang('hegyd-news::news.field.meta_keyword')</label>
        </div>
        <div class="col-md-10">
            {!! Form::text('meta_keyword', $model->meta_keyword, ['class' => 'form-control']) !!}
            {!! Form::errorMsg('meta_keyword', $errors) !!}
        </div>
    </div>
    <div class="form-group {!! Form::hasError('meta_robots', $errors) !!}">
        <div class="col-md-2">
            <label class="control-label">@lang('hegyd-news::news.field.meta_robots')</label>
        </div>
        <div class="col-md-10">
            {!! Form::select('meta_robots', $newsModel->metaRobots(), $model->meta_robots, ['class' => 'form-control']) !!}
            {!! Form::errorMsg('meta_robots', $errors) !!}
        </div>
    </div>
</div>

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
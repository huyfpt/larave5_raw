@if($model->seos)
    {!! Form::hidden('seos[id]', $model->seos->id) !!}
@endif
<div class="form-group {!! Form::hasError('seos.title', $errors) !!}">
    <label class="col-sm-2 control-label">@lang('seos.fields.title')
        @if(isset($required['title']) && $required['title'])
            <i class="required-field">*</i>
        @endif
    </label>
    <div class="col-sm-10">
        {!! Form::text('seos[title]', null, [
            'class' => 'form-control',
            isset($required['title']) && $required['title'] ? 'required' : '',
        ]) !!}
        {!! Form::errorMsg('seos.title', $errors) !!}
    </div>
</div>
<div class="form-group {!! Form::hasError('seos.description', $errors) !!}">
    <label class="col-sm-2 control-label">@lang('seos.fields.description')
        @if(isset($required['description']) && $required['description'])
            <i class="required-field">*</i>
        @endif
    </label>
    <div class="col-sm-10">
        {!! Form::textarea('seos[description]', null, [
            'class' => 'form-control',
            isset($required['description']) && $required['description'] ? 'required' : ''
        ]) !!}
        {!! Form::errorMsg('seos.description', $errors) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">@lang('seos.fields.keywords')</label>
    <div class="col-sm-10">
        {!! Form::text('seos[keywords]', null, [
            'class' => 'form-control',
            isset($required['keywords']) && $required['keywords'] ? 'required' : ''
        ]) !!}
    </div>
</div>
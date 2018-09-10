<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"
            aria-hidden="true">&times;</button>
    <h4 class="modal-title">{!! $title !!}</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($model, ['route' => $route, 'method' => $method, 'class' => '']) !!}
            {!! Form::hidden('type', $type) !!}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {!! Form::hasError('name', $errors) !!}">
                        <label class="control-label">@lang('addresses.fields.name') <i class="required-field">*</i></label>
                        {!! Form::text('name', null, [ 'class' => 'form-control', 'required', 'placeholder' => trans('addresses.placeholders.name')]) !!}
                        {!! Form::errorMsg('name', $errors) !!}
                    </div>
                    <div class="form-group {!! Form::hasError('firstname', $errors) !!}">
                        <label class="control-label">@lang('addresses.fields.firstname') <i class="required-field">*</i></label>
                        {!! Form::text('firstname', null, [ 'class' => 'form-control', 'required' ]) !!}
                        {!! Form::errorMsg('firstname', $errors) !!}
                    </div>
                    <div class="form-group {!! Form::hasError('lastname', $errors) !!}">
                        <label class="control-label">@lang('addresses.fields.lastname') <i class="required-field">*</i></label>
                        {!! Form::text('lastname', null, ['class' => 'form-control', 'required' ]) !!}
                        {!! Form::errorMsg('lastname', $errors) !!}
                    </div>
                    <div class="form-group {!! Form::hasError('phone', $errors) !!}">
                        <label class="control-label">@lang('addresses.fields.phone')</label>
                        {!! Form::text('phone', null, [ 'class' => 'form-control' ]) !!}
                        {!! Form::errorMsg('phone', $errors) !!}
                    </div>
                    <div class="form-group {!! Form::hasError('company', $errors) !!}">
                        <label class="control-label">@lang('addresses.fields.company')</label>
                        {!! Form::text('company', null, [ 'class' => 'form-control']) !!}
                        {!! Form::errorMsg('company', $errors) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group {!! Form::hasError('address', $errors) !!}">
                        <label class="control-label">@lang('addresses.fields.address') <i class="required-field">*</i></label>
                        {!! Form::text('address', null, [
                            'class' => 'form-control', 'required'
                        ]) !!}
                        {!! Form::errorMsg('address', $errors) !!}
                    </div>
                    <div class="form-group {!! Form::hasError('additional_1', $errors) !!}">
                        <label class="control-label">@lang('addresses.fields.additional')</label>
                        {!! Form::text('additional_1', null, ['class' => 'form-control']) !!}
                        {!! Form::errorMsg('additional_1', $errors) !!}
                    </div>
                    <div class="form-group {!! Form::hasError('zip', $errors) !!}">
                        <label class="control-label">@lang('addresses.fields.zip') <i class="required-field">*</i></label>
                        {!! Form::text('zip', null, [
                        'class' => 'form-control', 'required'
                        ]) !!}
                        {!! Form::errorMsg('zip', $errors) !!}
                    </div>
                    <div class="form-group {!! Form::hasError('city', $errors) !!}">
                        <label class="control-label">@lang('addresses.fields.city') <i class="required-field">*</i></label>
                        {!! Form::text('city', null, [
                        'class' => 'form-control',
                         'required'
                         ]) !!}
                        {!! Form::errorMsg('city', $errors) !!}
                    </div>
                    <div class="form-group {!! Form::hasError('country_id', $errors) !!}">
                        <label class="control-label">@lang('addresses.fields.country')</label>
                        {!! Form::hidden('address_country_id', $model->exists ? $model->country_id : null ) !!}
                        {!! Form::select('country_id', [], null, [
                        'class' => 'form-control select2', 'id' => 'country_id',
                         ]) !!}
                        {!! Form::errorMsg('country_id', $errors) !!}
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-3">@lang('app.required_fields')</div>
                        <div class="col-md-9">
                            <div class="actions pull-right">
                                {!! Form::submit(trans('app.buttons.save'), ['class' => 'btn btn-primary btn-lg']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
        <div class="col-md-12 loading hide text-center">
            <i class="fa fa-circle-o-notch fa-spin text-danger fa-5x"></i>
        </div>
    </div>
</div>
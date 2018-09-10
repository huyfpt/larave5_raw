<div class="white-box">
    <div class="form-group {!! Form::hasError('active', $errors) !!}">
        <label class="control-label col-md-2">@lang('users.fields.active')</label>
        <div class="col-md-9">
            @php
                if(strstr($_SERVER['REQUEST_URI'], 'creation') == true)
                    $checked = 'checked';
                else
                    $checked = '';
            @endphp
            {!! Form::checkbox('active', 1, $model->user->active, ['class' => 'js-switch', $checked]) !!}
            {!! Form::errorMsg('active', $errors) !!}
        </div>
    </div>
    <div class="form-group {!! Form::hasError('club_lilial', $errors) !!}">
        <label class="control-label col-md-2">@lang('clients.fields.club_lilial')</label>
        <div class="col-md-9">
            {!! Form::checkbox('club_lilial', 1, $model->club_lilial, ['class' => 'js-switch']) !!}
            {!! Form::errorMsg('club_lilial', $errors) !!}
        </div>
    </div>
    <div class="form-group {!! Form::hasError('ambassador', $errors) !!}">
        <label class="control-label col-md-2">@lang('clients.fields.ambassador')</label>
        <div class="col-md-9">
            {!! Form::checkbox('ambassador', 1, $model->ambassador, ['class' => 'js-switch']) !!}
            {!! Form::errorMsg('ambassador', $errors) !!}
        </div>
    </div>
    <div class="form-group {!! Form::hasError('type', $errors) !!}">
        <label class="control-label col-md-2" for="type">
            @lang('clients.fields.type') <i class="required-field">*</i>
        </label>
        <div class="col-md-9">
            {!! Form::select('type', $clientService->types(), $model->type, ['class' => 'form-control', 'id'=>'type', 'required']) !!}
            {!! Form::errorMsg('type', $errors) !!}
        </div>
    </div>
    <div class="form-group {!! Form::hasError('civility', $errors) !!}">
        <label class="control-label col-md-2" for="civility">
            @lang('users.fields.civility') <i class="required-field">*</i>
        </label>
        <div class="col-md-9">
            {!! Form::select('civility', $userService->civilities(), $model->user->civility, ['class' => 'form-control', 'id'=>'civility', 'required']) !!}
            {!! Form::errorMsg('civility', $errors) !!}
        </div>
    </div>
    <div class="form-group {!! Form::hasError('lastname', $errors) !!}">
        <label class="control-label col-md-2" for="lastname">
            @lang('users.fields.lastname') <i class="required-field">*</i>
        </label>
        <div class="col-md-9">
            {!! Form::text('lastname', $model->user->lastname, ['class' => 'form-control', 'id'=>'lastname', 'required']) !!}
            {!! Form::errorMsg('lastname', $errors) !!}
        </div>
    </div>
    <div class="form-group {!! Form::hasError('firstname', $errors) !!}">
        <label class="control-label col-md-2" for="firstname">
            @lang('users.fields.firstname') <i class="required-field">*</i>
        </label>
        <div class="col-md-9">
            {!! Form::text('firstname', $model->user->firstname, ['class' => 'form-control', 'id'=>'firstname', 'required']) !!}
            {!! Form::errorMsg('firstname', $errors) !!}
        </div>
    </div>
    <div class="form-group {!! Form::hasError('email', $errors) !!}">
        <label class="control-label col-md-2" for="email">
            @lang('users.fields.email') <i class="required-field">*</i>
        </label>
        <div class="col-md-9">
            {!! Form::text('email', $model->user->email, ['class' => 'form-control', 'id'=>'email', 'required']) !!}
            {!! Form::errorMsg('email', $errors) !!}
        </div>
    </div>
    <div class="form-group {!! Form::hasError('mobile', $errors) !!}">
        <label class="control-label col-md-2" for="mobile">
            @lang('users.fields.mobile')
        </label>
        <div class="col-md-9">
            {!! Form::text('mobile', $userService->convertPhone($model->user->mobile), ['class' => 'form-control', 'id'=>'mobile']) !!}
            <label for="mobile" class="hintText">Ex: +33 6 70 44 29 63, +33670442963, 06 70 44 29 63, 06-70-44-29-63, 0670442963</label>
            {!! Form::errorMsg('mobile', $errors) !!}
        </div>
    </div>
</div>

<div class="white-box">
    <h3 class="box-title">@lang('users.subtitle.security')</h3>
    @include('app.includes.form.passwords')
</div>

<div class="white-box">
    <h3 class="box-title">@lang('users.subtitle.address')</h3>
    @include('app.contents.admin.clients.includes.form.addressable', ['field_div_class' => 'col-md-9'])
</div>

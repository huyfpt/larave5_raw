@extends('layouts.app')
@inject('roleService', 'App\Services\ACL\RoleService')
@inject('userService', 'App\Services\Common\UserService')
@inject('shopService', 'App\Services\Common\ShopService')

@section('title', $title)

@section('content')

    {!! Form::model($model, ['route' => $route, 'method' => $method, 'id' => 'userForm', 'class' => 'form-horizontal js-validate', 'files' => true]) !!}
    <div class="row">
        <div class="white-box">
            <div class="row">
                @include('app.contents.admin.users.includes.form.actions')
            </div>
        </div>
    </div>
    <div class="row">
        <div class="white-box">
            <div class="row">
                <div class="col-md-12">

                    <div class="form-group {!! Form::hasError('active', $errors) !!}">
                        <label class="control-label col-md-2">@lang('users.fields.active')</label>
                        <div class="col-md-9">
                            @php
                                if(strstr($_SERVER['REQUEST_URI'], 'creation') == true)
                                    $checked = 'checked';
                                else
                                    $checked = '';
                            @endphp
                            {!! Form::checkbox('active', 1, $model->active, ['class' => 'js-switch', $checked]) !!}
                            {!! Form::errorMsg('active', $errors) !!}
                        </div>
                    </div>

                    <div class="form-group {!! Form::hasError('username', $errors) !!}">
                        <label class="control-label col-md-2" for="username">
                            @lang('users.fields.username') <i class="required-field">*</i>
                        </label>
                        <div class="col-md-9">
                            {!! Form::text('username', $model->username, ['class' => 'form-control', 'id'=>'username', 'required']) !!}
                            {!! Form::errorMsg('username', $errors) !!}
                        </div>
                    </div>

                    <div class="form-group {!! Form::hasError('email', $errors) !!}">
                        <label class="control-label col-md-2" for="email">
                            @lang('users.fields.email') <i class="required-field">*</i>
                        </label>
                        <div class="col-md-9">
                            {!! Form::text('email', $model->email, ['class' => 'form-control', 'id'=>'email', 'required']) !!}
                            {!! Form::errorMsg('email', $errors) !!}
                        </div>
                    </div>

                    <div class="form-group {!! Form::hasError('civility', $errors) !!}">
                        <label class="control-label col-md-2" for="civility">
                            @lang('users.fields.civility') <i class="required-field">*</i>
                        </label>
                        <div class="col-md-9">
                            {!! Form::select('civility', $userService->civilities(), $model->civility, ['class' => 'form-control', 'id'=>'civility', 'required']) !!}
                            {!! Form::errorMsg('civility', $errors) !!}
                        </div>
                    </div>

                    <div class="form-group {!! Form::hasError('lastname', $errors) !!}">
                        <label class="control-label col-md-2" for="lastname">
                            @lang('users.fields.lastname') <i class="required-field">*</i>
                        </label>
                        <div class="col-md-9">
                            {!! Form::text('lastname', $model->lastname, ['class' => 'form-control', 'id'=>'lastname', 'required']) !!}
                            {!! Form::errorMsg('lastname', $errors) !!}
                        </div>
                    </div>

                    <div class="form-group {!! Form::hasError('firstname', $errors) !!}">
                        <label class="control-label col-md-2" for="firstname">
                            @lang('users.fields.firstname') <i class="required-field">*</i>
                        </label>
                        <div class="col-md-9">
                            {!! Form::text('firstname', $model->firstname, ['class' => 'form-control', 'id'=>'firstname', 'required']) !!}
                            {!! Form::errorMsg('firstname', $errors) !!}
                        </div>
                    </div>

                    <div class="form-group {!! Form::hasError('mobile', $errors) !!}">
                        <label class="control-label col-md-2" for="mobile">
                            @lang('users.fields.mobile')
                        </label>
                        <div class="col-md-9">
                            {!! Form::text('mobile', $userService->convertPhone($model->mobile), ['class' => 'form-control', 'id'=>'mobile']) !!}
                            <label for="mobile" class="hintText">Ex: +33 6 70 44 29 63, +33670442963, 06 70 44 29 63, 06-70-44-29-63, 0670442963</label>
                            {!! Form::errorMsg('mobile', $errors) !!}
                        </div>
                    </div>

                    {{--@include('app.includes.form.select2', [
                        'select_id'         => 'shops',
                        'label'             => 'users.fields.shops',
                        'class'             => 'selectable2',
                        'field'             => 'shop_id',
                        'values'            => $shopService->getSelectList(),
                        'selected_value'    => $model->shops()->first() ? $model->shops()->first()->id : null,
                        'label_class'       => 'col-md-2',
                        'div_class'         => 'col-md-9',
                        'required'          => true,
                    ])--}}

                    @include('app.includes.form.select2', [
                        'select_id'         => 'roles',
                        'label'             => 'users.fields.roles',
                        'class'             => 'selectable2',
                        'field'             => 'role_id',
                        'values'            => $roleService->getSelectList(),
                        'selected_value'    => $model->roles()->first() ? $model->roles()->first()->id : null,
                        'label_class'       => 'col-md-2',
                        'div_class'         => 'col-md-9',
                        'required'          => true,
                    ])

                    @include('app.includes.form.image1', ['model' => $model, 'label' => trans('users.fields.avatar')])
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="white-box">
            <h3 class="box-title">@lang('users.subtitle.security')</h3>
            @include('app.includes.form.passwords')
        </div>
    </div>


    <div class="row">
        <div class="white-box">
            <h3 class="box-title">@lang('users.subtitle.address')</h3>
            @include('app.contents.admin.users.includes.form.addressable', ['field_div_class' => 'col-md-9'])
        </div>
    </div>

    <div class="row">
        <div class="white-box">
            <div class="row">
                @include('app.contents.admin.users.includes.form.actions')
            </div>
        </div>
    </div>

    {!! Form::close() !!}

@endsection

@push('scripts')
    {!! Html::script('/vendor/bower/jquery-validation/dist/jquery.validate.js') !!}

    {!! Html::script('/app/js/users/form.js') !!}
@endpush
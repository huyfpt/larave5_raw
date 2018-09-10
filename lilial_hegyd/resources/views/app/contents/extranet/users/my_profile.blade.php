@extends('layouts.app')
@inject('userService', 'App\Services\Common\UserService')

@section('title', $title)
@section('content')
    {!! Form::model($user, ['route' => 'extranet.users.my_profile.update', 'method' => 'PUT',  'id' => 'userForm', 'class' => 'form-horizontal js-validate', 'files' => true]) !!}

    <div class="row">
        <div class="col-md-3">
            <div class="white-box text-center">
                <img class="img-circle" src="{{ $user->media() }}" width="100"
                     height="100"
                     alt="{{ $user->firstname }} {{ $user->lastname }}"/>
                <h3 class="box-title v2">{{ $user->firstname }} {{ $user->lastname }}</h3>
                <p>
                    <small>@if($user->phone){{ $user->phone }} @endif</small>
                </p>
                <p>
                    <small>@if($user->email){{ $user->email }} @endif</small>
                </p>
            </div>
        </div>

        <div class="col-md-9">
            <div class="white-box">
                <div class="row">
                    <div class="col-md-12">


                        <div class="form-group {!! Form::hasError('username', $errors) !!}">
                            <label class="control-label col-md-2">@lang('users.fields.username')</label>
                            <div class="input-group col-md-9">
                                {!! Form::text('username', $user->username, ['class' => 'form-control', 'readonly']) !!}
                                {!! Form::errorMsg('username', $errors) !!}
                            </div>
                        </div>

                        <div class="form-group {!! Form::hasError('civility', $errors) !!}">
                            <label for=""
                                   class="col-md-2 label-control">@lang('users.fields.civility')
                                <i class="required-field">*</i></label>
                            <div class="input-group  col-md-9">
                                {!! Form::select('civility', $userService->civilities(), null,['class' => 'form-control']) !!}
                                {!! Form::errorMsg('civility', $errors) !!}
                            </div>
                        </div>
                        <div class="form-group {!! Form::hasError('lastname', $errors) !!}">
                            <label class="control-label col-md-2">@lang('users.fields.lastname')
                                <i class="required-field">*</i></label>
                            <div class="input-group col-md-9">
                                {!! Form::text('lastname', $user->lastname, ['class' => 'form-control']) !!}
                                {!! Form::errorMsg('lastname', $errors) !!}
                            </div>
                        </div>

                        <div class="form-group {!! Form::hasError('firstname', $errors) !!}">
                            <label class="control-label col-md-2">@lang('users.fields.firstname')
                                <i class="required-field">*</i></label>
                            <div class="input-group col-md-9">
                                {!! Form::text('firstname', $user->firstname, ['class' => 'form-control']) !!}
                                {!! Form::errorMsg('firstname', $errors) !!}
                            </div>
                        </div>

                        <div class="form-group {!! Form::hasError('email', $errors) !!}">
                            <label class="control-label col-md-2">@lang('users.fields.email')
                                <i class="required-field">*</i></label>
                            <div class="input-group col-md-9">
                                {!! Form::email('email', $user->email, ['class' => 'form-control', 'readonly']) !!}
                                {!! Form::errorMsg('email', $errors) !!}
                            </div>
                        </div>

                        <div class="form-group {!! Form::hasError('phone', $errors) !!}">
                            <label class="control-label col-md-2">@lang('users.fields.phone')</label>
                            <div class="input-group col-md-9">
                                {!! Form::text('phone', $userService->convertPhone($user->phone), ['class' => 'form-control']) !!}
                                <label for="mobile" class="hintText">Ex: +33 6 70 44 29 63, +33670442963, 06 70 44 29 63, 06-70-44-29-63, 0670442963</label>
                                {!! Form::errorMsg('phone', $errors) !!}
                            </div>
                        </div>

                        <div class="form-group {!! Form::hasError('role', $errors) !!}">
                            <label class="control-label col-md-2">@lang('users.fields.role')</label>
                            <div class="input-group col-md-9">
                                {!! Form::text('text', $current_role->display_name, ['class' => 'form-control', 'disabled']) !!}
                                {!! Form::errorMsg('role', $errors) !!}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9 col-md-push-3">
            <div class="white-box">
                <div class="row">
                    <div class="col-md-12">
                        @include('app.includes.form.image', ['model' => $user, 'label' => trans('users.fields.avatar'), 'show_remove' => "false"])
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9 col-md-push-3">
            <div class="white-box">
                <h3 class="box-title">@lang('users.subtitle.security')</h3>
                <div class="row">
                    <div class="col-md-12">
                        @include('app.includes.form.passwords')

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9 col-md-push-3">
            <div class="white-box">
                <h3 class="box-title">@lang('users.subtitle.newsletter')</h3>
                <div class="row">
                    <div class="col-md-12">
                        <label class="control-label">@lang('users.fields.newsletter')</label>&nbsp;
                        {!! Form::checkbox('newsletter', true, null, ['class' => 'switcheryable']) !!}
                    </div>
                </div>
            </div>
        </div>

        @if($user->can('extranet.profile.edit'))
            <div class="col-md-9 col-md-push-3">
                <div class="white-box">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-md-offset-3 col-md-8">
                                    <div class="actions pull-right">
                                        <button type="submit" name="save"
                                                class="btn btn-primary save-btn">
                                            @lang('app.buttons.save')
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {!! Form::close() !!}

@endsection


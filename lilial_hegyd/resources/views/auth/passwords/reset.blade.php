@extends('layouts.auth')

@section('content')
    {!! Form::open(['route' => 'auth.password.postReset', 'method' => 'post', 'class' => 'form-horizontal'])!!}
    {!! Form::hidden('token', $token) !!}
    <h3 class="box-title m-b-20">@lang('auth.title.reset')</h3>
    <p>@lang('auth.subtitle.reset')</p>
    <div class="form-group {!! Form::hasError('username', $errors) !!}">
        <div class="col-xs-12">
            {!! Form::text('username', old('username'), ['class' => 'form-control', 'required', 'placeholder' => trans('auth.fields.username')]) !!}
            {!! Form::errorMsg('username', $errors) !!}
        </div>
    </div>
    <div class="form-group {!! Form::hasError('password', $errors) !!}">
        <div class="col-xs-12">
            {!! Form::password('password', ['class' => 'form-control', 'required', 'placeholder' => trans('auth.fields.password')]) !!}
            {!! Form::errorMsg('password', $errors) !!}
        </div>
    </div>
    <div class="form-group {!! Form::hasError('password_confirmation', $errors) !!}">
        <div class="col-xs-12">
            {!! Form::password('password_confirmation', ['class' => 'form-control', 'required', 'placeholder' => trans('auth.fields.password_confirmation')]) !!}
            {!! Form::errorMsg('password_confirmation', $errors) !!}
        </div>
    </div>
    <div class="form-group">
        <div class="text-center">
            <button type="submit" class="btn btn-primary">
                @lang('auth.buttons.reset')
            </button>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@extends('layouts.auth')
@section('title', trans('auth.title.login'))
@section('content')
{!! Form::open(['route' => 'auth.postLogin', 'method' => 'post', 'class' => 'form-horizontal'])!!}
    <h3 class="box-title m-b-20"><center>@lang('auth.title.login')</center></h3>
    <div class="form-group {!! Form::hasError('username', $errors) !!}">
        <div class="col-xs-12">
            {!! Form::text('username', null, ['class' => 'form-control', 'required', 'placeholder' => trans('auth.fields.username')]) !!}
            {!! Form::errorMsg('username', $errors) !!}
        </div>
    </div>
    <div class="form-group {!! Form::hasError('password', $errors) !!}">
        <div class="col-xs-12">
            {!! Form::password('password', ['class' => 'form-control', 'required', 'placeholder' => trans('auth.fields.password')]) !!}
            {!! Form::errorMsg('password', $errors) !!}
        </div>
    </div>
    <div class="form-group text-center m-t-20">
        <div class="col-xs-12">
            <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">
                @lang('auth.buttons.sign_in')
            </button>
        </div>
    </div>
    <div class="form-group m-b-10">
        <div class="col-md-12">
            <a href="{{route('auth.password.getRequest')}}" id="to-recover" class="text-dark pull-right">
                <i class="fas fa-lock m-r-5"></i>
                @lang('auth.buttons.forgot_password')
            </a>
        </div>
    </div>
{!! Form::close() !!}
@endsection
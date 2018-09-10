@extends('layouts.auth')
@section('title', trans('auth.title.request'))
@section('content')
    {!! Form::open(['route' => 'auth.password.postRequest', 'method' => 'post', 'class' => 'form-horizontal'])!!}
    <h3 class="box-title m-b-20">@lang('auth.title.request')</h3>
    <p>@lang('auth.subtitle.request')</p>
    <div class="form-group {!! Form::hasError('username', $errors) !!}">
        <div class="col-xs-12">
            {!! Form::text('username', old('username'), ['class' => 'form-control', 'required', 'placeholder' => trans('auth.fields.username')]) !!}
            {!! Form::errorMsg('username', $errors) !!}
        </div>
    </div>
    <div class="form-group">
        <div class="text-center">
            <button type="submit" class="btn btn-primary">
                @lang('auth.buttons.request')
            </button>
        </div>
    </div>
    <div class="form-group m-b-10">
        <div class="col-md-12">
            <a href="{{ url('connexion') }}" id="to-recover" class="text-dark pull-right">
                <i class="fas fa-sign-in-alt m-r-5"></i>
                @lang('auth.buttons.sign_in')
            </a>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

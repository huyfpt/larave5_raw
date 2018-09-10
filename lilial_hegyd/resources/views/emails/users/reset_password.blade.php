@extends('emails.layouts.email')

@section('welcome')
    {{ isset($user) ? trans('emails.global.welcome', ['fullname' => $user->fullname()]) : '' }}
@endsection

@section('subject')
    {{ isset($title) ? $title : '' }}
@endsection

@section('message')
    <a href="{{ url('reinitialisation-mot-de-passe/'.$token) }}"><button class="btn btn-primary" style="height: 30px; border-radius: 5px; cursor: pointer;">Reset Password</button></a>
@endsection

@section('message2')

@endsection
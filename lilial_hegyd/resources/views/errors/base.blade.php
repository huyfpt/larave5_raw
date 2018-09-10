@extends('layouts.app')

@section('content')
    <div class="error-box">
        <div class="error-body text-center">
            <h1>{{$status}}</h1>
            <h3 class="text-uppercase">@lang("errors.$status.title")</h3>
            <p class="text-muted m-t-30 m-b-30">
                @lang("errors.$status.description")
            </p>
            <a href="/"
               class="btn btn-info btn-rounded waves-effect waves-light m-b-40">
                @lang("errors.$status.button")
            </a>
        </div>
    </div>
@endsection
@extends('layouts.app')
@inject('roleService', 'App\Services\ACL\RoleService')
@inject('userService', 'App\Services\Common\UserService')
@inject('clientService', 'App\Services\Common\ClientService')

@section('title', $title)

@section('content')

    {!! Form::model($model, ['route' => $route, 'method' => $method, 'id' => 'userForm', 'class' => 'form-horizontal js-validate', 'files' => true]) !!}
    <div class="row">
        <div class="white-box">
            <div class="row">
                <div class="ibox-title">
                    <h3>{!! $title !!}</h3>
                    <div class="ibox-tools">
                        @include('app.contents.admin.clients.includes.form.actions')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <ul class="nav nav-tabs" id="formTab">
            <li class="active"><a href="#tabReference" data-toggle="tab">
                @lang('clients.labels.tab_reference')
            </a></li>
            <li><a href="#tabImages" data-toggle="tab">
                @lang('clients.labels.tab_images')
            </a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade in active" id="tabReference">
                @include('app.contents.admin.clients.includes.tab.tab-reference')
            </div>
            <div class="tab-pane fade" id="tabImages">
                <div class="white-box">
                    @include('app.contents.admin.clients.includes.form.image')
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="white-box">
            <div class="row">
                @include('app.contents.admin.clients.includes.form.footer')
            </div>
        </div>
    </div>
    {!! Form::close() !!}

@endsection

@push('stylesheets')
    {!! Html::style('/vendor/bower/select2/dist/css/select2.min.css') !!}
@endpush

@push('scripts')
    {!! Html::script('/vendor/bower/jquery-validation/dist/jquery.validate.js') !!}

    {!! Html::script('/vendor/bower/select2/dist/js/select2.full.min.js') !!}
    
    {!! Html::script('/app/js/clients/form.js') !!}

@endpush

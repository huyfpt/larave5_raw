@extends('layouts.app')
@inject('shopService', 'App\Services\Common\ShopService')
@inject('countryService', 'App\Services\Common\CountryService')

@section('title',$title)

@section('content')

    {!! Form::model($model, ['route' => $route, 'method' => $method, 'class' => 'form-horizontal', 'files' => true]) !!}

    <div class="row">
        <div class="white-box">
            <div class="row">
                @include('app.includes.form.actions')
            </div>
        </div>
    </div>
    <div class="row">
        <div class="white-box">
            <div class="row">
                <div class="col-md-12">

                    <div class="form-group">
                        <label class="control-label col-md-2">@lang('shops.fields.active')</label>
                        <div class="col-md-9">
                            {!! Form::checkbox('active', 1, $model->active, ['class' => 'js-switch']) !!}
                            {!! Form::errorMsg('active', $errors) !!}
                        </div>
                    </div>

                    <div class="form-group {!! Form::hasError('head_office', $errors) !!}">
                        <label class="control-label col-md-2">@lang('shops.fields.head_office')</label>
                        <div class="col-md-9">
                            {{
                                Form::checkbox(
                                    'head_office',
                                    1,
                                    $model->head_office,
                                    ['class' => 'js-switch']
                                )
                            }}
                            {!! Form::errorMsg('head_office', $errors) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2" for="name">
                            @lang('shops.fields.name') <i class="required-field">*</i>
                        </label>
                        <div class="input-group col-md-9">
                            {!!
                                Form::text(
                                    'name',
                                    $model->name,
                                    ['class' => 'form-control', 'id'=>'name', 'required']
                                )
                            !!}
                            {!! Form::errorMsg('name', $errors) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2" for="client_code">
                            @lang('shops.fields.client_code') <i class="required-field">*</i>
                        </label>
                        <div class="input-group col-md-9">
                            {!!
                                Form::text(
                                    'client_code',
                                    $model->client_code,
                                    ['class' => 'form-control', 'id'=>'client_code']
                                )
                            !!}
                            {!! Form::errorMsg('client_code', $errors) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2" for="email">
                            @lang('shops.fields.email') <i class="required-field">*</i>
                        </label>
                        <div class="input-group col-md-9">
                            {!!
                                Form::text(
                                    'email',
                                    $model->email,
                                    ['class' => 'form-control', 'id'=>'email', 'required']
                                )
                            !!}
                            {!! Form::errorMsg('email', $errors) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2" for="director_email">
                            @lang('shops.fields.director_email')
                        </label>
                        <div class="input-group col-md-9">
                            {!!
                                Form::text(
                                    'director_email',
                                    $model->director_email,
                                    ['class' => 'form-control', 'id'=>'director_email']
                                )
                            !!}
                            {!! Form::errorMsg('director_email', $errors) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2" for="phone">
                            @lang('shops.fields.phone')
                        </label>
                        <div class="input-group col-md-9">
                            {!!
                                Form::text(
                                    'phone',
                                    $model->phone,
                                    ['class' => 'form-control', 'id'=>'phone']
                                )
                            !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2" for="fax">
                            @lang('shops.fields.fax')
                        </label>
                        <div class="input-group col-md-9">
                            {!!
                                Form::text(
                                    'fax',
                                    $model->fax,
                                    ['class' => 'form-control', 'id'=>'fax']
                                )
                            !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2" for="siret">
                            @lang('shops.fields.siret')
                        </label>
                        <div class="input-group col-md-9">
                            {!!
                                Form::text(
                                    'siret',
                                    $model->siret,
                                    ['class' => 'form-control', 'id'=>'siret']
                                )
                            !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2" for="siren">
                            @lang('shops.fields.siren')
                        </label>
                        <div class="input-group col-md-9">
                            {!!
                                Form::text(
                                    'siren',
                                    $model->siren,
                                    ['class' => 'form-control', 'id'=>'siren']
                                )
                            !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2" for="ape">
                            @lang('shops.fields.ape')
                        </label>
                        <div class="input-group col-md-9">
                            {!!
                                Form::text(
                                    'ape',
                                    $model->ape,
                                    ['class' => 'form-control', 'id'=>'ape']
                                )
                            !!}
                        </div>
                    </div>

                    @include('app.includes.form.image')

                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="white-box">
            <h3 class="box-title">Adresse</h3>
            @include('app.includes.form.addressable', ['field_div_class' => 'col-md-9', 'display_lat_lng' => true])
        </div>
    </div>


    <div class="row">
        <div class="white-box">
            <div class="row">
                @include('app.includes.form.actions')
            </div>
        </div>
    </div>

    {!! Form::close() !!}

@endsection

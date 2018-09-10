@inject('userService', 'App\Services\Common\UserService')

@php
    $attribute = (isset($attribute) ? $attribute : $model->attribute);
@endphp

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">{!! $title !!}</h4>
</div>

{!!
    Form::model(
        $model,
        [
            'route' => $route,
            'method' => $method,
            'class' => 'form-horizontal',
            'files' => true
        ]
    )
!!}
@if($model->attribute_id)
    {!! Form::hidden('attribute_id') !!}
@else
    {!! Form::hidden('attribute_id', $attribute->id) !!}
@endif

<div class="modal-body">

    <div class="form-group {!! Form::hasError('value', $errors) !!}">
        <div class="col-md-3">
            <label for="name" class="control-label">
                @lang('eav.fields.value') <i class="required-field">*</i>
            </label>
        </div>
        <div class="col-md-9">
            {!! Form::text('value', null, ['class' => 'form-control', 'autofocus', 'required']) !!}
            {!! Form::errorMsg('value', $errors) !!}
        </div>
    </div>

    @if( isset($creationMode) && $creationMode )
        <div class="form-group {!! Form::hasError('position', $errors) !!}">
            <div class="col-md-3">
                <label for="name" class="control-label">
                    @lang('eav.fields.initial_position') <i class="required-field">*</i>
                </label>
            </div>
            <div class="col-md-9">
                {!!
                    Form::select(
                        'position',
                        $attribute->getInitialPositionsOptions(),
                        null,
                        ['class' => 'form-control', 'autofocus', 'required']
                    )
                !!}
                {!! Form::errorMsg('value', $errors) !!}
            </div>
        </div>
    @endif

    @if( $attribute->with_color )
        @include('app.includes.form.color', [
            'select_id'         => 'color',
            'label'             => 'eav.fields.color',
            'class'             => 'colorable',
            'required'          => true,
            'field'             => 'color',
            'value'             => $model->color,
            'label_class'       => 'col-md-3',
            'div_class'         => 'col-md-9',
        ])
    @endif

    @if( $attribute->with_users )
        @include('app.includes.form.select2', [
            'select_id'         => 'users',
            'label'             => 'eav.fields.users',
            'class'             => 'selectable2',
            'required'          => false,
            'multiple'          => true,
            'field'             => 'users[]',
            'values'            => $userService->populateFullname(),
            'selected_value'    => $model->users()->get()->pluck('id'),
            'label_class'       => 'col-md-3',
            'div_class'         => 'col-md-9',
            'placeholder'       => trans('eav.options.users.choose'),
        ])
    @endif

    @if( $attribute->with_roles )
        @include('app.includes.form.select2', [
            'select_id'         => 'roles',
            'label'             => 'eav.fields.roles',
            'class'             => 'selectable2',
            'required'          => false,
            'multiple'          => true,
            'field'             => 'roles[]',
            'values'            => [null=>trans('eav.options.roles.choose')]+$roleService->populateRolename(),
            'selected_value'    => $model->roles()->get()->pluck('id'),
            'label_class'       => 'col-md-3',
            'div_class'         => 'col-md-9',
        ])
    @endif

    <hr/>

    <div class="form-group">
        <div class="col-md-5">@lang('app.required_fields')</div>
        <div class="col-md-7">
            <div class="actions pull-right">
                <button type="submit" name="save" class="btn btn-primary save-btn">
                    @lang('app.buttons.save')
                </button>
            </div>
        </div>
    </div>


</div>

{!! Form::close() !!}
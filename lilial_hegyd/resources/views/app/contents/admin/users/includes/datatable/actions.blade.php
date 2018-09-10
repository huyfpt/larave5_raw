<div class="btn-group">
    {{--@if($object->hasAttribute('active') && Entrust::can($config['prefixes']['acl'] . 'edit'))--}}
        @php
            $isActive =  $object->active;
            $titleToggle = $isActive ? trans('app.disactivate') : trans('app.activate');
            $iconToggle =  $isActive ? 'fa-circle' : 'fa-circle-o';
        @endphp
        <a href="{!! route($config['prefixes']['route'] . 'toggle-active', $object->id) !!}"
           class="btn btn-white btn-sm toggle-active"
           data-active="{!! ! $isActive !!}"
           data-toggle="tooltip" data-placement="top"
           alt="{!! $titleToggle !!}" title="{!! $titleToggle !!}"
           data-original-title="{!! $titleToggle !!}">
            <i class="fa {!! $iconToggle !!}"></i>
        </a>
    {{--@endif
    @if( Entrust::can($config['prefixes']['acl'] . 'edit'))--}}
    <a href="{!! route($config['prefixes']['route'] . 'edit', $object->id) !!}"
       class="btn btn-white btn-sm"
       data-toggle="tooltip" data-placement="top"
       alt="@lang('app.edit')" title="@lang('app.edit')"
       data-original-title="@lang('app.edit')">
        <i class="fas fa-edit"></i>
    </a>
    {{--@endif
    @if( Entrust::can($config['prefixes']['acl'] . 'delete'))--}}
    <a class="btn btn-white btn-sm"
       data-toggle="tooltip" data-placement="top"
       title="@lang('app.delete')" alt="@lang('app.delete')"
       data-original-title="@lang('app.delete')"
       data-delete-url="{!! route($config['prefixes']['route'] . 'destroy', $object->id) !!}"
       data-text="{!! isset($config['delete-detail']) ? $config['delete-detail'] : '' !!}">
        <i class="fas fa-trash"></i>
    </a>
    {{--@endif
    @if($object->active && Entrust::can($config['prefixes']['acl'] . 'edit'))
    <a class="btn btn-white btn-sm force-reset-password"
       href="{!! route($config['prefixes']['route'] . 'force-reset-password', $object->id) !!}"
       data-toggle="tooltip" data-placement="top"
       title="@lang('users.buttons.forceResetPassword')" alt="@lang('app.forceResetPassword')"
       data-original-title="@lang('app.forceResetPassword')"
       data-text="{!! isset($config['force-reset-password-detail']) ? $config['force-reset-password-detail'] : '' !!}">
        <i class="fas fa-lock"></i>
    </a>
    @endif
    @role(['super_admin','admin'])
        @if(!session()->has('impersonateId'))
            <a class="btn btn-white btn-sm "
               href="{!! route('admin.users.loginas', ['id' => $object->id]) !!}"
               title="@lang('users.buttons.loginAs')"
               data-toggle="tooltip" >
                <i class="fas fa-sign-in-alt"></i>
            </a>
    
        @endif
    @endrole--}}
</div>
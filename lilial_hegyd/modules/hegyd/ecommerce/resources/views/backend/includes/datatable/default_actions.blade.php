<div class="btn-group">
    {{--<button type="button" class="btn btn-danger">Actions</button>--}}
    {{--<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">--}}
        {{--<span class="caret"></span>--}}
        {{--<span class="sr-only">Toggle Dropdown</span>--}}
    {{--</button>--}}
    {{--<ul class="dropdown-menu" role="menu">--}}
        {{-- @if (Auth::user()->can([$config['prefixes']['permission'] . 'update'])) --}}
        {{--<li>--}}
            {{--<a href="{{ Route($config['prefixes']['route'] . 'edit', $object->id) }}"--}}
               {{--alt="@lang('app.edit')"--}}
               {{--title="@lang('app.edit')">--}}
                {{--<i class="fa fa-edit"></i> Modifier--}}
            {{--</a>--}}
        {{--</li>--}}
        {{-- @endif --}}
        {{-- @if (Auth::user()->can([$config['prefixes']['permission'] . 'remove'])) --}}
        {{--<li>--}}
            {{--<a alt="@lang('app.delete?')"--}}
               {{--data-delete-url="{{ Route($config['prefixes']['route'] . 'destroy', $object->id) }}">--}}
                {{--<i class="fa fa-times"></i> Supprimer--}}
            {{--</a>--}}
        {{--</li>--}}
        {{-- @endif --}}
    {{--</ul>--}}

    {{-- @if($object->hasAttribute('active') && Entrust::can($config['prefixes']['acl'] . 'edit')) --}}
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
    {{-- @endif --}}
    {{-- @if( Entrust::can($config['prefixes']['acl'] . 'edit')) --}}
    <a href="{!! route($config['prefixes']['route'] . 'edit', $object->id) !!}"
       class="btn btn-white btn-sm"
       data-toggle="tooltip" data-placement="top"
       alt="@lang('app.edit')" title="@lang('app.edit')"
       data-original-title="@lang('app.edit')">
        <i class="fa fa-pencil"></i>
    </a>
    {{-- @endif --}}
    {{-- @if( Entrust::can($config['prefixes']['acl'] . 'delete')) --}}
    <a class="btn btn-white btn-sm"
       data-toggle="tooltip" data-placement="top"
       title="@lang('app.delete')" alt="@lang('app.delete')"
       data-original-title="@lang('app.delete')"
       data-delete-url="{!! route($config['prefixes']['route'] . 'destroy', $object->id) !!}"
       data-text="{!! isset($config['delete-detail']) ? $config['delete-detail'] : '' !!}">
        <i class="fa fa-trash"></i>
    </a>
    {{-- @endif --}}
</div>

<div class="btn-group">
    @if($object->hasAttribute('active') && auth()->user()->can($config['prefixes']['acl'] . 'edit'))
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
            <i class="fas {!! $iconToggle !!}"></i>
        </a>
    @endif
    @if( auth()->user()->can($config['prefixes']['acl'] . 'edit'))
    <a href="{!! route($config['prefixes']['route'] . 'edit', $object->id) !!}"
       class="btn btn-white btn-sm"
       data-toggle="tooltip" data-placement="top"
       alt="@lang('app.edit')" title="@lang('app.edit')"
       data-original-title="@lang('app.edit')">
        <i class="icon-pencil"></i>
    </a>
    @endif
    @if( auth()->user()->can($config['prefixes']['acl'] . 'delete'))
    <a class="btn btn-white btn-sm"
       data-toggle="tooltip" data-placement="top"
       title="@lang('app.delete')" alt="@lang('app.delete')"
       data-original-title="@lang('app.delete')"
       data-delete-url="{!! route($config['prefixes']['route'] . 'destroy', $object->id) !!}"
       data-text="{!! isset($config['delete-detail']) ? $config['delete-detail'] : '' !!}">
        <i class="fas fa-trash"></i>
    </a>
    @endif
</div>

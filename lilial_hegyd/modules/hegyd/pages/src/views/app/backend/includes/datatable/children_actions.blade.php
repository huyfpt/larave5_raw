<a href="{{ Route($config['prefixes']['child_route'] . 'list', $object->id) }}"
   alt="@Lang('app.list')"
   title="@Lang('app.list')"
   class="btn btn-success dropdown-toggle btn-xs">
    <i class="fa fa-list"></i>
</a>
@if (Auth::user()->can([$config['prefixes']['permission'] . 'update']))
<a href="{{ Route($config['prefixes']['route'] . 'edit', $object->id) }}"
   alt="@Lang('app.edit')"
   title="@Lang('app.edit')"
   class="btn btn-success dropdown-toggle btn-xs">
    <i class="fa fa-edit"></i>
</a>
@endif
@if (Auth::user()->can([$config['prefixes']['permission'] . 'remove']))
<a alt="@Lang('app.delete?')"
   data-delete-url="{{ Route($config['prefixes']['route'] . 'delete', $object->id) }}"
   class="btn btn-danger dropdown-toggle btn-xs"
   data-toggle="delete-confirmation"
   data-placement="left"
   data-original-title="@Lang('app.delete')"
   data-btn-ok-label="@Lang('app.Yes')"
   data-singleton="true"
   data-btn-cancel-label="@Lang('app.No')">
    <i class="fa fa-times"></i>
</a>
@endif
@if(count($category->permissions))
<table class="table table-bordered panelUsersRight">
    <thead>
        <tr>
            <th colspan="{!! count($roles) + 1 !!}">{!! $category->name !!}</th>
        </tr>
    </thead>
    <tbody>
    @foreach($category->permissions as $permission)
        <tr>
            <td class="col-md-3">{!! $permission->display_name !!}</td>
            @foreach($roles as $role)
                <td class="chekCol text-center">
                    <label class="checkRight">
                        <input type="checkbox"
                               name="roles[{!!$role->id!!}][permissions][{!!$permission->id!!}]"
                                {!! $role->hasPermission($permission->name) ? "checked" : "" !!}
                        <?= ($perm_edit) ? '' : 'disabled' ?> />
                        <span>{!! $role->display_name !!}</span>
                    </label>

                    @if ( isset($admin) && ! $admin && $role->name == 'director' )
                        <label class="checkRight v2">
                            <input type="checkbox"
                                   name="permissions[{!!$permission->id!!}]"
                                    {!! $permission->option ? "checked" : "" !!}
                            <?= ($perm_edit) ? '' : 'disabled' ?> />
                            <span>Option salarié</span>
                        </label>
                    @endif
                </td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
@endif
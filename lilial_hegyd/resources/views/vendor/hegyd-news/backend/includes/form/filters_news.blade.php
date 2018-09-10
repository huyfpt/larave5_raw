@include('app.includes.form.select2',[
    'multiple'          => true,
    'label'             => 'hegyd-news::news.field.roles',
    'field'             => 'role_ids[]',
    'select_id'         => 'roles',
    'placeholder'       => 'hegyd-news::news.field.roles',
    'values'            => app(\App\Services\ACL\RoleService::class)->getOtherSelectList(),
    'selected_value'    => $model->roles,
])


@include('app.includes.form.select2',[
    'multiple'          => true,
    'label'             => 'hegyd-faqs::faqs.field.roles',
    'field'             => 'role_ids[]',
    'select_id'         => 'roles',
    'placeholder'       => 'hegyd-faqs::faqs.field.roles',
    'values'            => app(\App\Services\ACL\RoleService::class)->getOtherSelectList(),
    'selected_value'    => $model->roles,
])


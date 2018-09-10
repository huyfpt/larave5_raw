@if($checked)
    <span class="label label-success">@lang('contacts.status.treated')</span>
@else
    <span class="label label-danger">@lang('contacts.status.waiting')</span>
@endif

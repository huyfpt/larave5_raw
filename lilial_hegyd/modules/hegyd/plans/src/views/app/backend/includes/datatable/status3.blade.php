@if($checked)
    <span class="label label-success">@lang('hegyd-plans::report_comment.status.treated')</span>
@else
    <span class="label label-danger">@lang('hegyd-plans::report_comment.status.wait')</span>
@endif

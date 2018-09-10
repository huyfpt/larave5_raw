<div class="btn-group pull-right">
    @if(!$model->comment->trashed())
    <a class="btn btn-white btn-sm delete-comment"
       data-toggle="tooltip" data-placement="top"
       title="@lang('hegyd-news::report_comment.buttons.delete_comment')" alt="@lang('hegyd-news::report_comment.buttons.delete_comment')"
       data-original-title="@lang('hegyd-news::report_comment.buttons.delete_comment')"
       href="{!! route(config('hegyd-news.routes.backend.comments.destroy'), $model->comment->id) !!}"
       data-form="delete"
       data-text="Supprimer le commentaire"
       data-confirm="true"
       data-ajax="true">
        <i class="fas fa-trash"></i>
    </a>
    @else
        <a class="btn btn-white btn-sm"
           data-toggle="tooltip"
           title="@lang('hegyd-news::comments.labels.removed')"
           data-original-title="@lang('hegyd-news::comments.labels.removed')">
            @lang('hegyd-news::comments.labels.removed')
        </a>

    @endif
    <a href="{{route(config('hegyd-news.routes.backend.report_comment.get_send_mail'), $model->id)}}"
       class="btn btn-white btn-sm send-mail"
       data-toggle="tooltip"
       title="@lang('hegyd-news::report_comment.buttons.contact_concerned_user')"
       data-original-title="@lang('hegyd-news::report_comment.buttons.contact_concerned_user')">
        <i class="icon-envelope"></i>
    </a>
</div>

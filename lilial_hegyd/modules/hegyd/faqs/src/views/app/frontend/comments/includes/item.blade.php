
@inject('comment_service', 'Hegyd\News\Services\NewsCommentService')
@php
    $auth = auth()->user();
    $user = $comment->author;
@endphp
<li class="timeline-inverted">
    <div class="pull-right menu-comment">
        @if($auth->id == $user->id)
            <a href="{{route(config('hegyd-news.routes.frontend.comments.edit-from-modal'), ['id' => $comment->news->id, 'comment_id' => $comment->id])}}"
               class="text-inverse p-r-5 btn btn-default btn-outline waves-effect edit-comment"
               data-toggle="tooltip"
               title="@lang('app.edit')"
               data-original-title="@lang('app.edit')">
                <i class="icon-pencil"></i>
            </a>
        @endif
        @if($auth->id != $user->id)
            @if(!$comment_service->getReportsByUser($comment))
                <a href="{{route(config('hegyd-news.routes.frontend.comments.get-report'), ['id' => $comment->news->id, 'comment_id' => $comment->id])}}"
                   class="text-inverse p-r-5 btn btn-default btn-outline waves-effect report-comment"
                   id="comment-report_{{ $comment->id }}"
                   data-toggle="tooltip"
                   title="@lang('hegyd-news::report_comment.buttons.report')"
                   data-original-title="@lang('hegyd-news::report_comment.buttons.report')">
                    <i class="ti-alert"></i>
                </a>
            @else
                <a class="text-inverse p-r-5 btn btn-default btn-outline waves-effect"
                   data-toggle="tooltip"
                   title="@lang('hegyd-news::report_comment.labels.already_report')"
                   data-original-title="@lang('hegyd-news::report_comment.labels.already_report')">
                    @lang('hegyd-news::report_comment.labels.already_report')
                </a>
            @endif
        @endif
    </div>
    <div class="timeline-badge success"><img class="img-responsive img-circle" style="width: 100%" src="{{$user->media('visual', \Hegyd\Uploads\Models\Upload::SIZE_SQUARE, 40)}}" alt="{{$user->fullname()}}"> </div>
    <div class="timeline-panel">
        <div class="timeline-heading">
            <h4 class="timeline-title m-t-10">{{ $user->fullname() }} <small class="text-muted pull-right m-t-5"><i class="fa fa-clock-o"></i> @lang('hegyd-news::comments.labels.publish_at') {{ $comment->updated_at->format('d/m/Y') }} à {{ $comment->updated_at->format('H:i:s') }}</small>
        </div>
        <div class="timeline-body">
            <p><strong>{{ $comment->name }}</strong> <br />
                    {!! $comment->content !!}</p>
        </div>
    </div>
</li>

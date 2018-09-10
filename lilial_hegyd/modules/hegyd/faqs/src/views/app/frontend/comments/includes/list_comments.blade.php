<div class="task-today m-t-0">
    <div class="pull-right m-t-20">
        @if($can_create_comment && $news->enable_comment && config('hegyd-news.enable_comment'))
            <div class="col-md-12">
                <a href="{{route(config('hegyd-news.routes.frontend.comments.create-from-modal'), $news->id)}}"
                   data-toggle="tooltip"
                   title="@lang('hegyd-news::news.button.add-comment')"
                   class="btn btn-info btn-rounded pull-right add-comment">@lang('hegyd-news::comments.buttons.comment')</a>
            </div>
        @endif
    </div>
    @if($comments->count() > 0)
        <h3>@lang('hegyd-news::comments.title.list')</h3>
        <p><small class="text-muted"><i class="fa fa-clock-o"></i> @lang('hegyd-news::comments.labels.count_comments', ['count_comment' => $comments->count()])</small> </p>
    @else
        <h3>@lang('hegyd-news::comments.labels.empty')</h3>
    @endif
</div>

@if($comments->count() > 0)
    <ul class="timeline-today">
        @forelse($comments as $comment)
            @include('hegyd-news::app.frontend.comments.includes.item')
        @empty
            <div>@lang('hegyd-news::comments.labels.empty')</div>
        @endforelse
    </ul>
@endif
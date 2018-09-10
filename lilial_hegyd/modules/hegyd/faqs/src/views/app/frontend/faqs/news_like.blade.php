@inject('service', 'Hegyd\News\Services\NewsService')

@php
    $userLike = $service->getUserLike($model->id);
    if(!$userLike)
        $userLike = new \Hegyd\News\Models\NewsLike();
    $countLike = $service->getCountLikes($model->id, config('hegyd-news.models.news_like')::STATUS_LIKE);
    $countDislike = $service->getCountLikes($model->id, config('hegyd-news.models.news_like')::STATUS_DISLIKE);
@endphp

@if($can_edit)
    <a href="{{ route(config('hegyd-news.routes.backend.news.edit'), $model->id) }}"
        class="btn btn-default btn-outline waves-effect"
        data-toggle="tooltip"
        title="@lang('hegyd-news::news.button.edit')"><i class="icon-pencil"></i>
    </a>
@endif
<a data-href="{{ route(config('hegyd-news.routes.frontend.news.like'), $model->id) }}"
    class="btn btn-info btn-rounded pull-right news_like"
    data-toggle="tooltip"
    title="@lang('hegyd-news::news.button.like')"
    data-id="{{ $model->id }}"
    data-like="{{ $userLike->status == config('hegyd-news.models.news_like')::STATUS_LIKE ? 0 : config('hegyd-news.models.news_like')::STATUS_LIKE }}"
    style="background-color: @if($userLike && $userLike->status == config('hegyd-news.models.news_like')::STATUS_LIKE) green @endif">
    <i class="fa fa-thumbs-up"></i>
    @if($countLike > 0 )
        <span class="badge-news badge-alert">
            {{ $countLike }}
        </span>
    @endif
</a>
<div class="clearfix"></div>
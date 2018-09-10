@extends(config('hegyd-news.main_layout.frontend'))

@section('title')
    {{$title}}
@endsection

@section('content')

<div class="row catList">
    @if($can_add || $can_edit)
        <div class="row">
            <div class="menu-admin pull-right">
                @if($can_edit)
                    <a class="btn btn-info btn-circle" href="{{ route(config('hegyd-news.routes.backend.news.index')) }}"
                       data-toggle="tooltip"
                       title="@lang('hegyd-news::news_categories.button.news')">
                        <i class="ti-settings"></i>
                    </a>
                @endif
                @if($can_add)
                    <a class="btn btn-info btn-circle" href="{{ route(config('hegyd-news.routes.backend.news.create'),['category_id' => $category->id]) }}"
                       data-toggle="tooltip"
                       title="@lang('hegyd-news::news.button.add')">
                        <i class="ti-plus"></i>
                    </a>
                @endif
            </div>
        </div>
    @endif
    @if(!$category->active)
        <div class="alert alert-danger">@lang('hegyd-news::news_categories.label.category_inactive')</div>
    @endif
    @include('hegyd-news::frontend.includes.menu_left')
    <div class="col-md-9">
        <div class="white-box">
            <h3 class="box-title">@lang('hegyd-news::news_categories.title.show_news', ['name' => $category->name])</h3>
            <div class="comment-center vCat">
                @if(count($all_news)) 
                    @foreach($all_news as $news)
                        @php($is_active = $news->isActive())
                        <div class="comment-body">
                        @if(!$is_active || $can_edit)
                            <div class="text-center">
                                @if(!$is_active)
                                <span class="ribbon"><i class="fa fa-eye-slash"></i></span>
                                @endif
                                @if($can_edit)
                                <a href="{{ route(config('hegyd-news.routes.backend.news.edit'), $news->id) }}"
                                   class="btn btn-info btn-circle"
                                   data-toggle="tooltip"
                                   title="@lang('hegyd-news::news.button.edit')"><i class="icon-pencil"></i></a>
                                @endif
                            </div>
                        @endif
                        <div class="pro-img">
                            <a href="{{ $news->url() }}">
                                <img src="{{$news->media()}}" alt="{{$news->name}}" />
                            </a>
                        </div>
                        <div class="mail-contnet">
                            <h5>
                                <a href="{{ $news->url() }}">
                                <span class="time pull-right">{{ $news->publishDate()->format('d/m/Y') }}</span>
                                {{$news->name}}
                                </a>
                            </h5>
                            <span class="mail-desc">
                                {{ \Illuminate\Support\Str::limit(strip_tags($news->content), 300) }}
                                <a href="{{ $news->url() }}">
                                    <strong>@lang('hegyd-news::news_categories.button.read-more')</strong>
                                </a>
                            </span>
                            @if(!$is_active)
                                <div class="alert alert-danger">@lang('hegyd-news::news.label.news_inactive')</div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center">
                        @lang('hegyd-news::news_categories.label.no_news')
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

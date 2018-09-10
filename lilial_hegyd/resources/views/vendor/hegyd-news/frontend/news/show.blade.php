@extends(config('hegyd-news.main_layout.frontend'))
@inject('service', 'Hegyd\News\Services\NewsService')

@section('title')
    {{$title}}
@endsection

@section('content')
    @php
        $author = $news->author;
    @endphp

    @if(!$news->isActive())
        <div class="alert alert-danger">@lang('hegyd-news::news.label.news_inactive')</div>
    @endif
    <div class="row catList">
        @include('hegyd-news::frontend.includes.menu_left')
        <div class="col-md-9">
            <div class="white-box">
                <div class="row">
                    <div class="col-md-12">
                        <div class="m-b-30">
                            <h1 class="font-bold m-t-0">
                                <div class="actions-article pull-right m-l-20">
                                    <div class="btn-group" id="like_{{ $news->id }}">
                                        @include('hegyd-news::app.frontend.news.news_like', ['model' => $news, 'can_edit' => $can_edit])
                                    </div>
                                </div>
                                {{ $news->name }}
                            </h1>

                            <hr>
                            <a class="pull-left" href="#">
                                <img class="media-object thumb-sm img-circle news-media" src="{{ $author->media() }}" alt="">
                            </a>
                            <div class="media-body media-profil">
                                <span class="media-meta pull-right">{{$news->publishDate()->format('d/m/Y')}}</span>
                                <h5 class="m-0">{{ $author->fullname() }}</h5>
                            </div>
                        </div>
                        @if($news->visual)
                            <div class="pull-left m-r-20 m-b-15">
                                <img class="img-news" src="{{ $news->media() }}" alt="">
                            </div>
                        @endif
                        <div>{!! $news->content !!}</div>
                    </div>
                </div>
            </div>
            <div class="row">
                @include('hegyd-news::app.frontend.comments.includes.list')
            </div>
        </div>
    </div>


@endsection

@push('stylesheets')
    {!! Html::style('/vendor/hegyd/news/css/news.css') !!}
    {!! Html::style('/vendor/hegyd/news/dependencies/summernote/dist/summernote.css') !!}
@endpush
@push('scripts')
    {!! Html::script('/vendor/hegyd/news/dependencies/summernote/dist/summernote.min.js') !!}
    {!! Html::script('/vendor/hegyd/news/dependencies/summernote/dist/lang/summernote-fr-FR.js') !!}
    {!! Html::script('/vendor/hegyd/news/dependencies/jquery-form/jquery.form.js') !!}
    {!! Html::script('/vendor/hegyd/news/js/frontend/news/index.js') !!}
    {!! Html::script('/vendor/hegyd/news/js/hegyd.js') !!}
    {!! Html::script('/vendor/hegyd/news/js/frontend/comments/index.js') !!}
@endpush
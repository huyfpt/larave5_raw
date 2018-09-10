@extends(config('hegyd-faqs.main_layout.frontend'))
@inject('repository', 'Hegyd\Faqs\Repositories\Contracts\FaqsRepositoryInterface')

@php
    $role = app(config('hegyd-faqs.services.extranet'))->getRole();
@endphp

@section('title')
    {{$title}}
@endsection

@section('content')

    @if($can_add || $can_edit)
    <div class="row">
        <div class="menu-admin pull-right">
            @if($can_edit)
                <a class="btn btn-info btn-circle" href="{{ route(config('hegyd-faqs.routes.backend.faqs_category.index')) }}"
                    data-toggle="tooltip"
                    title="@lang('hegyd-faqs::faqs_categories.button.categories')">
                    <i class="ti-settings"></i>
                </a>
            @endif
            @if($can_add)
                <a class="btn btn-info btn-circle" href="{{ route(config('hegyd-faqs.routes.backend.faqs_category.create')) }}"
                    data-toggle="tooltip"
                    title="@lang('hegyd-faqs::faqs_categories.button.add')">
                    <i class="ti-plus"></i>
                </a>
            @endif
        </div>
    </div>
    @endif
    <div class="row catList categories">
        @if(count($categories))
            @foreach($categories as $category)
                <div class="col-md-3 col-xs-12 col-sm-4 category-box">
                    <div class="white-box">
                        @if($can_edit)
                        <a class="btn btn-info btn-circle"
                            href="{{ route(config('hegyd-faqs.routes.backend.faqs_category.edit'), $category->id) }}"
                            data-toggle="tooltip"
                            title="@lang('hegyd-faqs::faqs_categories.button.edit')">
                            <i class="icon-pencil"></i>
                        </a>
                        @endif
                        <a class="img-cat" href="{{ $category->url() }}">
                            <img class="img-responsive " alt="user" src="{{ $category->media() }}">
                        </a>
                        <div class="pull-right text-right">
                            @if(!$category->active)
                                <span class="ribbon"><i class="fa fa-eye-slash"></i></span>
                            @endif
                            <a class="text-muted m-l-10" href="#"><i class="ti-rss-alt"></i>
                                {{ $repository->getActiveByCategory($category->id, $role->id, [], true) }}
                            </a>
                        </div>
                        <h3 class="box-title">{{ $category->name }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit($category->grip, 90) }}</p>
                        <a href="{{ $category->url() }}" class="btn btn-info m-t-10 waves-light">@lang('hegyd-faqs::faqs_categories.button.discover_faqs')</a>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-md-12">
                <div class="alert alert-danger text-center">
                    @lang('hegyd-faqs::faqs_categories.label.no_faqs')
                </div>
            </div>
        @endif
    </div>
@endsection

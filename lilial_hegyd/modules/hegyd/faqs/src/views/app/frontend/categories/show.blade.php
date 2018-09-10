@extends(config('hegyd-faqs.main_layout.frontend'))

@section('title')
    {{$title}}
@endsection

@section('content')

<div class="row catList">
    @if($can_add || $can_edit)
        <div class="row">
            <div class="menu-admin pull-right">
                @if($can_edit)
                    <a class="btn btn-info btn-circle" href="{{ route(config('hegyd-faqs.routes.backend.faqs.index')) }}"
                        data-toggle="tooltip"
                        title="@lang('hegyd-faqs::faqs_categories.button.faqs')">
                        <i class="ti-settings"></i>
                    </a>
                @endif
                @if($can_add)
                    <a class="btn btn-info btn-circle" href="{{ route(config('hegyd-faqs.routes.backend.faqs.create'),['category_id' => $category->id]) }}"
                        data-toggle="tooltip"
                        title="@lang('hegyd-faqs::faqs.button.add')">
                        <i class="ti-plus"></i>
                    </a>
                @endif
            </div>
        </div>
    @endif
    @if(!$category->active)
        <div class="alert alert-danger">@lang('hegyd-faqs::faqs_categories.label.category_inactive')</div>
    @endif
    @include('hegyd-faqs::frontend.includes.menu_left')
    <div class="col-md-9">
        <div class="white-box">
            <h3 class="box-title">@lang('hegyd-faqs::faqs_categories.title.show_faqs', ['name' => $category->name])</h3>
            <div class="comment-center vCat">
                @if(count($all_faqs)) 
                    @foreach($all_faqs as $faqs)
                        @php($is_active = $faqs->isActive())
                        <div class="comment-body">
                        @if(!$is_active || $can_edit)
                            <div class="text-center">
                                @if(!$is_active)
                                <span class="ribbon"><i class="fa fa-eye-slash"></i></span>
                                @endif
                                @if($can_edit)
                                <a href="{{ route(config('hegyd-faqs.routes.backend.faqs.edit'), $faqs->id) }}"
                                    class="btn btn-info btn-circle"
                                    data-toggle="tooltip"
                                    title="@lang('hegyd-faqs::faqs.button.edit')"><i class="icon-pencil"></i></a>
                                @endif
                            </div>
                        @endif
                        <div class="pro-img">
                            <a href="{{ $faqs->url() }}">
                                <img src="{{$faqs->media()}}" alt="{{$faqs->name}}" />
                            </a>
                        </div>
                        <div class="mail-contnet">
                            <h5>
                                <a href="{{ $faqs->url() }}">
                                <span class="time pull-right">{{ $faqs->publishDate()->format('d/m/Y') }}</span>
                                {{$faqs->name}}
                                </a>
                            </h5>
                            <span class="mail-desc">
                                {{ \Illuminate\Support\Str::limit(strip_tags($faqs->content), 300) }}
                                <a href="{{ $faqs->url() }}">
                                    <strong>@lang('hegyd-faqs::faqs_categories.button.read-more')</strong>
                                </a>
                            </span>
                            @if(!$is_active)
                                <div class="alert alert-danger">@lang('hegyd-faqs::faqs.label.faqs_inactive')</div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center">
                        @lang('hegyd-faqs::faqs_categories.label.no_faqs')
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

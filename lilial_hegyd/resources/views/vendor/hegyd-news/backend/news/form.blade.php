@extends(config('hegyd-news.main_layout.backend'))
@inject('newsModel', 'App\Models\Common\News')

@section('title')
    {!! $title !!}
@endsection

@section('content')

    {!! Form::model($model, ['route' => $route, 'method' => $method, 'class' => 'form-horizontal', 'id' => 'news_form', 'files' => true]) !!}
    <div class="row">
        <div class="white-box">
            <div class="row">
                <div class="ibox-title">
                    <h3>{!! $title !!}</h3>
                    <div class="ibox-tools">
                        @include('hegyd-news::backend.includes.form.actions')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <ul class="nav nav-tabs" id="formTab">
            <li class="active"><a href="#tabReference" data-toggle="tab">
                @lang('hegyd-news::news.labels.tab_reference')
            </a></li>
            <li><a href="#tabImages" data-toggle="tab">
                @lang('hegyd-news::news.labels.tab_images')
            </a></li>
            <li><a href="#tabSeo" data-toggle="tab">
                @lang('hegyd-news::news.labels.tab_seo')
            </a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade in active" id="tabReference">
                @include('hegyd-news::backend.news.includes.tab-reference')
            </div>
            <div class="tab-pane fade" id="tabImages">
                <div class="white-box">
                    @include('hegyd-news::backend.includes.form.image', ['required' => true])
                </div>
            </div>
            <div class="tab-pane fade" id="tabSeo">
                @include('hegyd-news::backend.news.includes.tab-seo')
            </div>
        </div>
    </div>

    <div class="row">
        <div class="white-box">
            <div class="row">
                @include('hegyd-news::backend.includes.form.footer')
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    @include('hegyd-news::backend.news.includes.category-modal', ['category' => new \Hegyd\News\Models\NewsCategory()])

@endsection

@push('stylesheets')
    {!! Html::style('/vendor/hegyd/news/dependencies/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') !!}
    {!! Html::style('/vendor/hegyd/news/dependencies/select2/dist/css/select2.min.css') !!}
    {!! Html::style('/vendor/hegyd/news/dependencies/summernote/dist/summernote.css') !!}
@endpush
@push('scripts')
    {!! Html::script('/vendor/hegyd/news/dependencies/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') !!}
    {!! Html::script('/vendor/hegyd/news/dependencies/bootstrap-datepicker/dist/locales/bootstrap-datepicker.fr.min.js') !!}
    {!! Html::script('/vendor/hegyd/news/dependencies/select2/dist/js/select2.full.min.js') !!}
    {!! Html::script('/vendor/hegyd/news/dependencies/select2/dist/js/i18n/fr.js') !!}
    {!! Html::script('/vendor/hegyd/news/dependencies/summernote/dist/summernote.min.js') !!}
    {!! Html::script('/vendor/hegyd/news/dependencies/summernote/dist/lang/summernote-fr-FR.js') !!}
    {!! Html::script('/vendor/hegyd/news/dependencies/jquery-form/jquery.form.js') !!}
    {!! Html::script('/vendor/hegyd/news/js/modal.js') !!}
    {!! Html::script('/vendor/hegyd/news/js/news/form.js') !!}
    {!! Html::script('/vendor/hegyd/news/js/news/changetoslug.js') !!}
    {!! Html::script('/vendor/hegyd/news/js/news/validate.js') !!}

    {!! Html::script('/app/js/summernote/summernote-ajax-upload-image.js') !!}
@endpush
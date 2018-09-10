@extends(config('hegyd-news.main_layout.backend'))

@section('title')
    {!! $title !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                {!! Form::model($model, ['route' => $route, 'method' => $method, 'class' => 'form-horizontal', 'files' => true]) !!}
                <div class="ibox-title">
                    <h3>{!! $title !!}</h3>
                    <div class="ibox-tools">
                        @include('hegyd-news::backend.report_comment.includes.form_actions')
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group {!! Form::hasError('active', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-news::report_comment.fields.active')</label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::checkbox('active', 1, null, ['class' => 'switcheryable']) !!}
                                {!! Form::errorMsg('active', $errors) !!}
                            </div>
                        </div>
                        @if($model->comment && $model->comment->news)
                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-news::report_comment.fields.news_name')</label>
                            </div>
                            <div class="col-md-10">
                                <a href="{{ $model->comment->news->url() }}" target="_blank" rel="noopener noreferrer">
                                    {{ $model->comment->news->name }}
                                </a>
                            </div>
                        </div>
                        @endif
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-news::report_comment.fields.content')</label>
                            </div>
                            <div class="col-md-10">
                                {!! $model->content  !!}
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        @php
                            $users_reports = $model->users;
                        @endphp
                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-news::report_comment.fields.user_report')</label>
                            </div>
                            <div class="col-md-10">
                                @foreach($users_reports as $user)
                                    {{ $user->fullname() }}
                                    <div class="clearfix"></div>
                                @endforeach
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-news::report_comment.fields.comment')</label>
                            </div>
                            <div class="col-md-10">
                                {!! $model->comment->content !!}
                            </div>
                        </div>
                        @php
                            $comment_author = $model->comment->author;
                        @endphp
                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-news::report_comment.fields.author')</label>
                            </div>
                            <div class="col-md-10">
                                {{ $comment_author->fullname() }}
                            </div>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="actions pull-right">
                        <a name="cancel-btn" href="{!! URL::previous() !!}" class="btn btn-default bg-navy cancel-btn">
                            @lang('app.buttons.back')
                        </a>
                        <button type="submit" name="save" class="btn btn-primary save-btn">
                            @lang('app.buttons.save')
                        </button>
                    </div>
                </div>


                {!! Form::close() !!}
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
    {!! Html::script('/vendor/hegyd/news/js/hegyd.js') !!}
    {!! Html::script('/vendor/hegyd/news/js/backend/comments/show.js') !!}
@endpush
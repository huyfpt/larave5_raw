@extends(config('hegyd-faqs.main_layout.backend'))

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
                    {{-- <div class="ibox-tools">
                        @include('hegyd-faqs::backend.includes.form.actions',[
                            'more_actions' => [
                                [
                                    'text' => trans('hegyd-faqs::faqs_categories.button.show_page'),
                                    'href' => $model->url(),
                                    'target' =>'_blank',
                                    'class' => 'btn-default',
                                    'only_exists' => true,
                                ]
                            ]
                        ])
                    </div> --}}
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group {!! Form::hasError('label', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-faqs::faqs_categories.field.label') <i class="required-field">*</i></label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::text('label', null, ['class' => 'form-control']) !!}
                                {!! Form::errorMsg('label', $errors) !!}
                            </div>
                        </div>
                        <div class="form-group {!! Form::hasError('introduction', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-faqs::faqs_categories.field.introduction')</label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::text('introduction', null, ['class' => 'form-control']) !!}
                                {!! Form::errorMsg('introduction', $errors) !!}
                            </div>
                        </div>
                        <div class="form-group {!! Form::hasError('status', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-faqs::faqs_categories.field.status')</label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::checkbox('status', 1, null, ['class' => 'switcheryable']) !!}
                                {!! Form::errorMsg('status', $errors) !!}
                            </div>
                        </div>

                        <div class="form-group {!! Form::hasError('parent_id', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-faqs::faqs_categories.field.parent_id') <i class="required-field">*</i></label>
                            </div>
                            <div class="col-md-8">

                                {!! Form::select('parent_id', $categories, $category_selected, ['class' => 'form-control']) !!}
                                {!! Form::errorMsg('parent_id', $errors) !!}
                            </div>
                            {{-- @if(Entrust::can(config('hegyd-faqs.permissions.backend.faqs_category.create')))
                                <a data-toggle="modal" data-target="#modal-category" href="" class="btn btn-primary" style="padding: 8px 12px">
                                    <i class="fa fa-plus" aria-hidden="true"></i> 
                                </a>
                            @endif --}}
                        </div>

                        @include('hegyd-faqs::backend.includes.form.image')
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                @include('hegyd-faqs::backend.includes.form.footer',[
                    'more_actions' => [
                        [
                            'text' => trans('hegyd-faqs::faqs_categories.button.show_page'),
                            'href' => $model->url(),
                            'target' =>'_blank',
                            'class' => 'btn-default',
                            'only_exists' => true
                        ]
                    ]
                ])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
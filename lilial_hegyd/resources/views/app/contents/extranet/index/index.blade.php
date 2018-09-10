@extends('layouts.app')
@section('title', $title)
@section('content')

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-users fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                        <div class="huge">{{$counter['cUser']}}</div>
                        <div>{{ trans('dashboard.counter.user_active')}}</div>
                        </div>
                    </div>
                </div>
                @if(Entrust::can('admin.clients.index'))
                <a href="{!! route('admin.clients.index') !!}">
                    <div class="panel-footer">
                        <span class="pull-left">{{trans('dashboard.view_detail')}}</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
                @endif
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-envelope-o fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$counter['cNewsletter']}}</div>
                            <div>{{ trans('dashboard.counter.newsletter_active')}}</div>
                        </div>
                    </div>
                </div>
                <a href="{!! route('admin.newsletters.index') !!}">
                    <div class="panel-footer">
                        <span class="pull-left">{{trans('dashboard.view_detail')}}</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-tasks fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$counter['cPlan']}}</div>
                            <div>{{ trans('dashboard.counter.plans_active')}}</div>
                        </div>
                    </div>
                </div>
                <a href="{!! route('admin.plans.index') !!}">
                    <div class="panel-footer">
                        <span class="pull-left">{{trans('dashboard.view_detail')}}</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- /.row -->
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-cubes fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{$counter['cProduct']}}</div>
                                <div>{{ trans('dashboard.counter.product_active')}}</div>
                            </div>
                        </div>
                    </div>
                    <a href="{!! route('admin.products.index') !!}">
                        <div class="panel-footer">
                            <span class="pull-left">{{trans('dashboard.view_detail')}}</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-file-text-o fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{$counter['cNews']}}</div>
                                <div>{{ trans('dashboard.counter.news_active')}}</div>
                            </div>
                        </div>
                    </div>
                    @if(Entrust::can('admin.news.index'))
                    <a href="{!! route('admin.news.index') !!}">
                        <div class="panel-footer">
                            <span class="pull-left">{{trans('dashboard.view_detail')}}</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                    @endif
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-lightbulb-o fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{$counter['cFaq']}}</div>
                                <div>{{ trans('dashboard.counter.faqs_active')}}</div>
                            </div>
                        </div>
                    </div>
                    @if(Entrust::can('admin.faqs.index'))
                    <a href="{!! route('admin.faqs.index') !!}">
                        <div class="panel-footer">
                            <span class="pull-left">{{trans('dashboard.view_detail')}}</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                    @endif
                </div>
            </div>
            
        </div>
        <!-- /.row -->
    <div class="row">
        <div class="col-md-7">
            @if($isAdmin)
                @include('app.contents.extranet.index.includes.connexions')
            @endif
        </div>
    </div>
@endsection
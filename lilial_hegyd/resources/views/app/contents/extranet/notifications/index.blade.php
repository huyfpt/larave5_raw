@extends('layouts.app')

@section('title')
    {{$title}}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <div class="ibox float-e-margins">


                    <div class="ibox-title">
                        <h3>@lang('notifications.title.index')</h3>
                        <div class="ibox-tools v2">
                            <a href="" class="btn btn-primary read-all">@lang('notifications.buttons.read-all')</a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="feed-activity-list notifications">
                            @include('app.contents.extranet.notifications.includes.table')
                        </div>
                        <div id="selectNotifPerPage" value="">
                            {!! Form::select('nbNotifPerPage',$arrayNbNotif,$perPageSelected,['class'=>'form-control']) !!}
                        </div>
                        <div id="numerosPagesNotif">
                            {!! $notifications->render(); !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('stylesheets')
{!! Html::style('/vendor/bower/select2/dist/css/select2.min.css') !!}
@endpush
@push('scripts')
{!! Html::script('/vendor/bower/select2/dist/js/select2.full.min.js') !!}
{!! Html::script('/vendor/bower/select2/dist/js/i18n/fr.js') !!}
{!! HTML::script('/app/js/notifications/index.js') !!}
@endpush
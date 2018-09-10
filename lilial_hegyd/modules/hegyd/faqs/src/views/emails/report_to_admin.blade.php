@extends('hegyd-news::layouts.email'))

@section('welcome')
    @lang('hegyd-news::emails.global.welcome', ['fullname' => 'Administrateur'])
@endsection
@section('subject')
    @lang('hegyd-news::emails.report.admin.subject', [

    ])
@endsection

@section('message')
    @lang('hegyd-news::emails.report.admin.message', [
        'link_report' => route(config('hegyd-news.routes.backend.report_comment.edit'), $report->id)
    ])
@endsection

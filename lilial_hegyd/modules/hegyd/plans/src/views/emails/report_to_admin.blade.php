@extends('hegyd-plans::layouts.email'))

@section('welcome')
    @lang('hegyd-plans::emails.global.welcome', ['fullname' => 'Administrateur'])
@endsection
@section('subject')
    @lang('hegyd-plans::emails.report.admin.subject', [

    ])
@endsection

@section('message')
    @lang('hegyd-plans::emails.report.admin.message', [
        'link_report' => route(config('hegyd-plans.routes.backend.report_comment.edit'), $report->id)
    ])
@endsection

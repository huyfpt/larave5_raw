@extends('hegyd-plans::layouts.email'))
@php
    $comment = $report->comment;
    $content_comment = $comment->content;
    $author = $comment->author;
@endphp
@section('welcome')
    @lang('hegyd-plans::emails.global.welcome', ['fullname' => $author->fullname()])
@endsection
@section('subject')
    @lang('hegyd-plans::emails.report.user.subject', [
    'site_name' => '',
    'reason'   => $reason
    ])
@endsection

@section('message')
    @lang('hegyd-plans::emails.report.user.message', [
        'author'     => $author->fullname(),
        'comment'    => $content_comment,
        'reason'     => $reason,
        'details'    => $details
    ])
@endsection

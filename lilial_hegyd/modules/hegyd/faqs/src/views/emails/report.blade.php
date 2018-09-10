@extends('hegyd-news::layouts.email'))
@php
    $comment = $report->comment;
    $content_comment = $comment->content;
    $author = $comment->author;
@endphp
@section('welcome')
    @lang('hegyd-news::emails.global.welcome', ['fullname' => $author->fullname()])
@endsection
@section('subject')
    @lang('hegyd-news::emails.report.user.subject', [
    'site_name' => '',
    'reason'   => $reason
    ])
@endsection

@section('message')
    @lang('hegyd-news::emails.report.user.message', [
        'author'     => $author->fullname(),
        'comment'    => $content_comment,
        'reason'     => $reason,
        'details'    => $details
    ])
@endsection

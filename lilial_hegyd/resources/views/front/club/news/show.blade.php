@extends('layouts.front')

@section('title')
  <title>Lilial French News Detail</title>
@endsection

@section('css')
@endsection

@section('content')
  <section class="main">
    @include('front.club.news.includes.news-detail-slider')
    <!-- END: HOME SLIDER-->
    @include('front.club.news.includes.news-detail-content')
  </section>
@endsection

@section('js')
@endsection
@extends('layouts.front')

@section('title')
  <title>Lilial French Club-News</title>
@endsection

@section('css')
@endsection

@section('content')
  <section class="main">
    @include('front.club.news.includes.news-slider')
    <!-- END: NEWS SLIDER-->
    @include('front.club.news.includes.news-filter')
    <!-- END: NEWS FILTER-->
    @include('front.club.news.includes.news-content')
  </section>
@endsection

@section('js')
@endsection
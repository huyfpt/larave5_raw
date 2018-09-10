@extends('layouts.front')

@section('title')
  <title>Lilial French About</title>
@endsection

@section('css')
@endsection

@section('content')
  <section class="main">
    @include('front.about.includes.about-slider')
    <!-- END: ABOUT SLIDER-->
    @include('front.about.includes.about-content')
  </section>
@endsection

@section('js')
@endsection
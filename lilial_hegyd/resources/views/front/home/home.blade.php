@extends('layouts.front')

@section('title')
  <title>Lilial French</title>
@endsection

@section('css')
@endsection

@section('content')
  <section class="main">
    @include('front.home.includes.home-slider')
    <!-- END: HOME SLIDER-->
    @include('front.home.includes.home-content')
  </section>
@endsection

@section('js')
@endsection
@extends('layouts.front')

@section('title')
  <title>Lilial French Pages</title>
@endsection

@section('css')
@endsection

@section('content')
  <section class="main">
    @include('hegyd-pages::frontend.pages.includes.pages-slider')
    <!-- END: HOME SLIDER-->
    @include('hegyd-pages::frontend.pages.includes.pages-content')
  </section>
@endsection

@section('js')
@endsection
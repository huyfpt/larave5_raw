@extends('layouts.front')

@section('title')
  <title>Lilial French Product Show</title>
@endsection

@section('css')
@endsection

@section('content')
  <section class="main">
    @include('front.product.includes.product-show-slider')
    <!-- END: HOME SLIDER-->
    @include('front.product.includes.product-show-content')
  </section>
@endsection

@section('js')
  <script src="{{ asset('front/js/plugins/bootstrap-checkbox.min.js') }}"></script>
  <script src="{{ asset('front/js/plugins/lightgallery.min.js') }}"></script>
@endsection
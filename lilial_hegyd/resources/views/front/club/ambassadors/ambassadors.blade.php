@extends('layouts.front')

@section('title')
  <title>Lilial French Club-Ambassadors</title>
@endsection

@section('css')
@endsection

@section('content')
  <section class="main">
    @include('front.club.ambassadors.includes.ambassadors-slider')
    <!-- END: NEWS SLIDER-->
    @include('front.club.ambassadors.includes.ambassadors-content')
  </section>
@endsection

@section('js')
@endsection
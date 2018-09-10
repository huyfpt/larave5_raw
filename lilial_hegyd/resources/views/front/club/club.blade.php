@extends('layouts.front')

@section('title')
  <title>Lilial French Club</title>
@endsection

@section('css')
@endsection

@section('content')
  <section class="main">
    @include('front.club.includes.club-slider')
    <!-- END: CLUB SLIDER-->
    @include('front.club.includes.club-content')
  </section>
@endsection

@section('js')
@endsection
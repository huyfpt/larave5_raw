@extends('layouts.front')

@section('title')
  <title>Lilial French Club-List</title>
@endsection

@section('css')
@endsection

@section('content')
  <section class="main">
    @include('front.club.includes.club-list-slider')
    <!-- END: CLUB SLIDER-->
    @include('front.club.includes.club-list-content')
  </section>
@endsection

@section('js')
@endsection
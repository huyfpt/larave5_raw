@extends('layouts.front')

@section('title')
  <title>Lilial French Profile</title>
@endsection

@section('css')
@endsection

@section('content')
  <section class="main">
    @include('front.profile.includes.profile-slider')
    <!-- END: HOME SLIDER-->
    @include('front.profile.includes.profile-content')
  </section>
@endsection

@section('js')
@endsection
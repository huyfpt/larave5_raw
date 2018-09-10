@extends('layouts.front')

@section('title')
  <title>Lilial French Contact</title>
@endsection

@section('css')
@endsection

@section('content')
  <section class="main">
    @include('front.contact.includes.contact-slider')
    <!-- END: ABOUT SLIDER-->
    @include('front.contact.includes.contact-content')
  </section>
@endsection

@section('js')
@endsection
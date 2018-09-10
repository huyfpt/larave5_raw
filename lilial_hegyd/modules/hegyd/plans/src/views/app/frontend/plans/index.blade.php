@extends('layouts.front')

@section('title')
  <title>Lilial French Plans</title>
@endsection

@section('css')
@endsection

@section('content')
  <section class="main">
    @include('hegyd-plans::frontend.plans.includes.plans-slider')
    <!-- END: HOME SLIDER-->
    @include('hegyd-plans::frontend.plans.includes.plans-content')
  </section>
@endsection

@section('js')
@endsection
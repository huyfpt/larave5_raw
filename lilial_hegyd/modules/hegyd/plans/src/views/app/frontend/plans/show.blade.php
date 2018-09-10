@extends('layouts.front')

@section('title')
  <title>Lilial French Plans Detail</title>
@endsection

@section('css')
@endsection

@section('content')
  <section class="main">
    @include('hegyd-plans::frontend.plans.includes.plans-detail-slider')
    <!-- END: PLANS SLIDER-->
    @include('hegyd-plans::frontend.plans.includes.plans-detail-content')
  </section>
@endsection

@section('js')
@endsection
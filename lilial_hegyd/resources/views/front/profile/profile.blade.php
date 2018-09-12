@extends('layouts.front')
@inject('userService', 'App\Services\Common\UserService')
@inject('plansService', 'Hegyd\Plans\Services\PlansService')

@section('title')
  <title>Lilial French Profile</title>
@endsection

@section('css')
  {!! Html::style('/vendor/hegyd/plans/dependencies/select2/dist/css/select2.min.css') !!}
  {!! Html::style('/vendor/bower/switchery/dist/switchery.min.css') !!}
@endsection

@section('content')
  <section class="main">
    @include('front.profile.includes.profile-slider')
    <!-- END: HOME SLIDER-->
    @include('front.profile.includes.profile-content')
  </section>
@endsection

@section('js')
  {!! Html::script('/vendor/hegyd/plans/dependencies/select2/dist/js/select2.full.min.js') !!}
  {!! Html::script('/app/js/passwords/generate.js') !!}
  {!! Html::script('/vendor/bower/switchery/dist/switchery.min.js') !!}
  <script src="{{ asset('front/js/profile/form.js') }}"></script>
@endsection
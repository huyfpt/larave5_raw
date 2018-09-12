@extends('layouts.front')

@section('title')
  <title>Lilial - Merci</title>
@endsection

@section('css')
@endsection

@section('content')
  <section class="main">
    <div class="blk-slider blk-breadcrumb">
      <div class="blk-banner-info">
        <div class="breadcrumb-wrap">
          <div class="container"><a href="{{ url('/') }}">Accueil</a><span>Merci</span></div>
        </div>
      </div>
    </div>
    <div class="error-box">
        <div class="error-body text-center">
            <h3 class="text-uppercase">Merci</h3>
            <p class="text-muted m-t-30 m-b-30">
              @lang('contacts.messages.thanks');
            </p>
        </div>
    </div>

  </section>
@endsection

@section('js')
@endsection
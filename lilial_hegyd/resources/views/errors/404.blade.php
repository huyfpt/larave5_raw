@extends('layouts.front')

@section('title')
  <title>Lilial - Erreur 404</title>
@endsection

@section('css')
@endsection

@section('content')
  <section class="main">
    <div class="blk-slider blk-breadcrumb">
      <div class="blk-banner-info">
        <div class="breadcrumb-wrap">
          <div class="container"><a href="{{ url('/') }}">Accueil</a><span>404</span></div>
        </div>
      </div>
    </div>
    <div class="error-box">
        <div class="error-body text-center">
            <h3 class="text-uppercase">404 Introuvable</h3>
            <p class="text-muted m-t-30 m-b-30">
              Désolé, une erreur est survenue, page demandée introuvable!
            </p>
        </div>
    </div>

  </section>
@endsection

@section('js')
@endsection
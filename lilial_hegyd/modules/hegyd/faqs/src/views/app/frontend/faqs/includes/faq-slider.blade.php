<div class="blk-slider blk-banner"><img src="{{ asset('front/uploads/prod-banner.png') }}" alt="">
  <!-- IMG FOR PC-->
  <div style="background-image: url({{$actual_link}}/front/uploads/prod-banner.png)" class="banner-thumb"></div>
  <!-- IMG FOR MOBILE-->
  <div class="blk-banner-info">
    <div class="breadcrumb-wrap">
      {{-- <div class="container"><a href="{{ url('/') }}">Accueil</a><a href="{{ url('/faqs') }}">Nos produits </a><span>Urologie</span></div> --}}
      <div class="container">{!!$breadcrumb!!}</div>
    </div>
    <!-- END : BREADCRUMB-->
    <h1 class="banner-ttl">FAQ</h1>
  </div>
</div>
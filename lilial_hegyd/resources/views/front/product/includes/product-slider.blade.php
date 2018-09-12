<div class="blk-slider blk-banner"><img src="{{ asset('front/uploads/prod-banner.png') }}" alt="">
  <!-- IMG FOR PC-->
  <div style="background-image: url( {{ asset('/front/uploads/prod-banner.png') }} )" class="banner-thumb"></div>
  <!-- IMG FOR MOBILE-->
  <div class="blk-banner-info">

    <div class="breadcrumb-wrap">
      <div class="container">
        @if (isset($breadcrumb))
            {!! $breadcrumb !!}
        @endif
      </div>
    </div>

    <!-- END : BREADCRUMB-->
    <h1 class="banner-ttl">{{ $h1 }}</h1>
  </div>
</div>
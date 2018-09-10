<div class="blk-main-content">
    {{-- <div class="blk-slider blk-page-banner"><img src="{{ asset('front/uploads/Visuel_video@2x.jpg') }}" alt="">
      <!-- IMG FOR PC-->
      <div style="background-image: url({{$actual_link}}/front/uploads/Visuel_video@2x.jpg)" class="banner-thumb"></div>
      <!-- IMG FOR MOBILE-->
      <div class="page-banner-info">
        <h1 class="ttl">Qui sommes-nous ?</h1><i style="background-image: url('{{$actual_link}}/front/uploads/icons/ico-play.png)" class="ico"></i>
      </div>
    </div> --}}
    <!-- END: BANNER-->
    <div class="home-about blk-page-desc">
      <div class="container">
          {{-- <figure class="prod-img"><img src="{{ asset($pages->media('visual', $type=4, $width=100)) }}" alt=""></figure> --}}
        <h2 class="prod-detail-ttl">{{$pages->title}}</h2>
      <div class="text-left">{!! $pages->content !!}</div>
      </div>
    </div>
    <!-- END: DESC-->

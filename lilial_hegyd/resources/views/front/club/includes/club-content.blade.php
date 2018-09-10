  <div class="blk-main-content">
  <div class="blk-slider blk-page-banner"><img src="{{ asset('front/uploads/club-banner.png') }}" alt="">
    <!-- IMG FOR PC-->
    <div style="background-image: url({{$actual_link}}/front/uploads/club-banner.png)" class="banner-thumb"></div>
    <!-- IMG FOR MOBILE-->
    <div class="page-banner-info">
      <h1 class="ttl">Le club Lilial</h1><i style="background-image: url({{$actual_link}}/front/uploads/icons/ico-play.png)" class="ico"></i>
    </div>
  </div>
  <!-- END: BANNER-->
  <div class="info-grid clearfix info-club">
    <div class="w50">&nbsp;</div>
    <div class="w50"> <img src="{{ asset('front/uploads/club-avatar.png') }}" alt="">
      <!-- IMG FOR PC-->
    </div>
    <div class="info-wrap">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-sm-12 info-img"> <img src="{{ asset('front/uploads/club-avatar.png') }}" alt=""></div>
          <!-- END : IMG FOR MOBILE-->
          <div class="col-md-6 col-sm-12 info-left"> 
            <div class="info"> 
              <h2 class="blk-title">Démarche du club Lilial </h2>
              <div class="txt"> 
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ornare vitae nunc non iaculis. Nam dictum vitae magna at imperdiet. Cras tincidunt purus in nunc laoreet auctor. Curabitur ac commodo sem, quis tempus sem. Integer ligula dolor, luctus et bibendum eu, iaculis eu dolor. Aliquam auctor purus ipsum, quis consectetur est tincidunt at. Proin dignissim commodo arcu vitae consectetur.</p>
                <p>Sed vitae purus nec purus tempor sagittis. Maecenas gravida tincidunt maximus. Mauris pretium augue hendrerit elit mollis condimentum. Pellentesque scelerisque consectetur libero quis vehicula. Vestibuludio elementum dapibus. Ut </p>
              </div>
              <div class="lil-subscription">
                <div class="row">
                  <div class="col-md-4 col-sm-12 sub-title">
                    <h3 class="ttl">Demande d'inscription au club Lilial</h3>
                  </div>
                  <!-- END : TITLE-->
                  <div class="col-md-8 col-sm-12 sub-form">
                    <form>
                      <input type="text" placeholder="Adresse e-mail" class="sub-ipt">
                      <button class="sub-btn">Inscription</button>
                    </form>
                  </div>
                  <!-- END : FORM-->
                </div>
              </div>
            </div>
          </div>
          <!-- END-->
          <!-- END : LEFT-->
          <div class="col-md-6 col-sm-12 info-right"></div>
          <!-- END : RIGHT-->
        </div>
      </div>
    </div>
  </div>
  <!-- END: INFO-->
  <div class="home-news pad-80 club-plans">
    <div class="container">
      <h2 class="blk-title">La communauté</h2>
      <div class="blk-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ornare vitae nunc non iaculis. Nam dictum vitae magna at imperdiet. Cras tincidunt purus in nunc laoreet auctor. Curabitur ac commodo sem, quis tempus sem. Integer ligula dolor, luctus et bibendum eu, iaculis eu dolor. Aliquam auctor purus ipsum, quis consectetur est tincidunt at. Proin dignissim commodo arcu vitae consectetur.</div>
      {{--<div class="plans-wrap nw-list">
        <div class="row">
          @php $count_plans = 0; @endphp
          @foreach($plans as $item)
            @php $count_plans ++; @endphp
            @if($count_plans <= 3)
            <div class="col-md-4 col-sm-6 nw-item"><a href="{{ url('club/plans/'.$item->slug) }}" class="inner">
                <figure class="nw-img"><img src="{{ asset($item->media('visual', $type=3, $width=313)) }}" alt=""></figure>
                <div class="nw-info">
                  <h3 class="nw-ttl">{{ $item->title }}</h3>
                  <div class="txt">{!! $item->content !!}</div>
                  <div class="blk-arr"><span>Voir le détail</span><i class="fa fa-long-arrow-right"></i></div>
                </div></a></div>
            <!-- END : ITEM -->
            @endif
          @endforeach
        </div>
      </div>--}}
      <!-- END NEW PC-->
      <div class="plans-wrap nw-list nw-list-slider">
        @php $count_plans_slider = 0; @endphp
        @foreach($plans as $item)
          @php $count_plans_slider ++; @endphp
          @if($count_plans_slider <= 10)
          <div class="nw-item"><a href="{{ url('club/plans/'.$item->slug) }}" class="inner">
              <figure class="nw-img"><img src="{{ asset($item->media('visual', $type=3, $width=313)) }}" alt=""></figure>
              <div class="nw-info">
                <h3 class="nw-ttl">{{ $item->title }}</h3>
                <div class="txt">{!! $item->content !!}</div>
                <div class="blk-arr"><span>Voir le détail</span><i class="fa fa-long-arrow-right"></i></div>
              </div></a></div>
          <!--  END : ITEM-->
          @endif
        @endforeach
      </div>
      <!-- END : SLIDE NEWS MOBILE-->
      <div class="more text-center"><a href="{{ url('/club/plans') }}" class="btn btn-green">Voir tous les bons plans</a></div>
      <!-- END-->
    </div>
  </div>
  <!-- END: PLANS-->
  <div class="club-social">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-sm-12 sc-item"><a href="#" class="d-table"><i class="fa fa-facebook d-table-cell"></i>
            <h3 class="ttl d-table-cell">Rejoignez-nous sur Facebook</h3></a></div>
        <!-- END : ITEM-->
        <div class="col-md-6 col-sm-12 sc-item"><a href="#" class="d-table"><i class="fa fa-twitter d-table-cell"></i>
            <h3 class="ttl d-table-cell">Rejoignez-nous sur Twitter</h3></a></div>
        <!-- END : ITEM-->
      </div>
    </div>
  </div>
  <!-- END: SOCIAL-->
  <div class="home-news pad-80 club-plans">
    <div class="container">
      <h2 class="blk-title">Les actualies</h2>
      <div class="blk-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ornare vitae nunc non iaculis. Nam dictum vitae magna at imperdiet. Cras tincidunt purus in nunc laoreet auctor. Curabitur ac commodo sem, quis tempus sem. Integer ligula dolor, luctus et bibendum eu, iaculis eu dolor. Aliquam auctor purus ipsum, quis consectetur est tincidunt at. Proin dignissim commodo arcu vitae consectetur.</div>
      {{--<div class="plans-wrap nw-list">
        <div class="row">
          @php $count_news = 0; @endphp
          @foreach($news as $item)
            @php $count_news ++; @endphp
            @if($count_news <= 3)
            <div class="col-md-4 col-sm-6 nw-item"><a href="{{ url('club/news/'.$item->slug) }}" class="inner">
                <figure class="nw-img"><img src="{{ asset($item->media('visual', $type=3, $width=313)) }}" alt=""></figure>
                <div class="nw-info">
                  <h3 class="nw-ttl">{{ $item->name }}</h3>
                  <div class="txt">{!! $item->content !!}</div>
                  <div class="blk-arr"><span>Voir le détail</span><i class="fa fa-long-arrow-right"></i></div>
                </div></a></div>
            <!-- END : ITEM -->
            @endif
          @endforeach
        </div>
      </div>--}}
      <!-- END NEW PC-->
      <div class="plans-wrap nw-list nw-list-slider">
        @php $count_news_slider = 0; @endphp
        @foreach($news as $item)
          @php $count_news_slider ++; @endphp
          @if($count_news_slider <= 10)
          <div class="nw-item"><a href="{{ url('club/news/'.$item->slug) }}" class="inner">
              <figure class="nw-img"><img src="{{ asset($item->media('visual', $type=3, $width=313)) }}" alt=""></figure>
              <div class="nw-info">
                <h3 class="nw-ttl">{{ $item->name }}</h3>
                <div class="txt">{!! $item->content !!}</div>
                <div class="blk-arr"><span>Voir le détail</span><i class="fa fa-long-arrow-right"></i></div>
              </div></a></div>
          <!--  END : ITEM-->
          @endif
        @endforeach
      </div>
      <!-- END : SLIDE NEWS MOBILE-->
      <div class="more text-center"><a href="{{ url('/club/news') }}" class="btn btn-green">Voir tous les bons actualies</a></div>
      <!-- END-->
    </div>
  </div>
  <!-- END: PLANS-->
  <div class="blk-ambassadors pad-80">
    <div class="container">
      <h2 class="blk-title">Nos ambassadeurs</h2>
      {{--<div class="nw-list">
        <div class="row">
          @php $count_ambassadors = 0; @endphp
          @foreach($ambassadors as $item)
            @php $count_ambassadors ++; @endphp
            @if($count_ambassadors <= 3)
              <div class="col-md-4 col-sm-6 ambas-item nw-item"><a href="{{ url('/club/ambassadors/'.$item->user_id) }}" class="inner">
                  <figure class="nw-img"><img src="{{ asset($item->user->media('visual', $type=3, $width=313)) }}" alt=""></figure>
                  <div class="nw-info">
                    <h3 class="nw-ttl">{{ $item->user->firstname.' '.$item->user->lastname }}</h3>
                    <div class="txt">"Les sports mécaniques, plus qu'un exutoire, une passion"</div>
                    <div class="blk-arr"><span>Voir le détail</span><i class="fa fa-long-arrow-right"></i></div>
                  </div></a></div>
              <!-- END : ITEM-->
            @endif
          @endforeach
        </div>
      </div>--}}
      <!-- END : PC-->
      <div class="plans-wrap nw-list nw-list-slider">
        @php $count_ambassadors_slider = 0; @endphp
        @foreach($ambassadors as $item)
          @php $count_ambassadors_slider ++; @endphp
          @if($count_ambassadors_slider <= 10)
            <div class="ambas-item nw-item"><a href="{{ url('/club/ambassadors/'.$item->user_id) }}" class="inner">
                <figure class="nw-img"><img src="{{ asset($item->media('visual', $type=3, $width=313)) }}" alt=""></figure>
                <div class="nw-info">
                  <h3 class="nw-ttl">{{ $item->user->firstname.' '.$item->user->lastname }}</h3>
                  <div class="txt">"Les sports mécaniques, plus qu'un exutoire, une passion"</div>
                  <div class="blk-arr"><span>Voir le détail</span><i class="fa fa-long-arrow-right"></i></div>
                </div></a></div>
            <!-- END : ITEM-->
          @endif
        @endforeach
      </div>
      <!-- END : SLIDE NEWS MOBILE--><div class="more text-center"><a href="{{ url('/club/ambassadors') }}" class="btn btn-green">Voir tous les ambassadeurs</a></div>
      <!-- END-->
    </div>
  </div>
  <!-- END: ambassadors-->
  <div class="home-about blk-page-desc pad-60">
    <div class="container">
      <h2 class="blk-title">Référentiel d'animation</h2>
      <div class="about-txt text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ornare vitae nunc non iaculis. Nam dictum vitae magna at imperdiet. Cras tincidunt purus in nunc laoreet auctor. Curabitur ac commodo sem, quis tempus sem. Integer ligula dolor, luctus et bibendum eu, iaculis eu dolor. Aliquam auctor purus ipsum, quis consectetur est tincidunt at. Proin dignissim commodo arcu vitae consectetur.</div>
    </div>
  </div>
  <!-- END: DESC-->
  <div class="club-contact pad-60">
    <div class="container"><i style="background-image: url({{$actual_link}}/front/uploads/icons/ico-phone-w.png)" class="ico"></i>
      <h2 class="ttl">Besoin de nous contacter pour un renseignement ?</h2><a href="#" class="btn btn-white">Contactez-nous</a>
    </div>
  </div>
  <!-- END: CONTACT-->
  <div class="blk-reference pad-80">
    <div class="container">
      <h2 class="blk-title">Bloc référencement SECO</h2>
      <div class="row">
        <div class="col-md-6 col-sm-12 ref-left">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ornare vitae nunc non iaculis. Nam dictum vitae magna at imperdiet. Cras tincidunt purus in nunc laoreet auctor. Curabitur ac commodo sem, quis tempus sem. Integer ligula dolor, luctus et bibendum eu, iaculis eu dolor. Aliquam auctor purus ipsum, quis consectetur est tincidunt at. Proin dignissim commodo arcu vitae consectetur.</p>
          <h3 class="ttl">Titre h2 </h3>
          <p>Sed vitae purus nec purus tempor sagittis. Maecenas gravida tincidunt maximus. Mauris pretium augue hendrerit elit mollis condimentum. Pellentesque scelerisque consectetur libero quis vehicula. Vestibuludio elementum dapibus. Ut condimentum enim quam.Sed vitae purus nec purus tempor sagittis. Maecenas gravida tincidunt maximus. Mauris pretium augue hendrerit elit mollis condimentum. Pellentesque scelerisque consectetur libero quis vehicula. Vestibuludio elementum dapibus. Ut condimentum enim quam.</p>
        </div>
        <!-- END  LEFT-->
        <div class="col-md-6 col-sm-12 ref-right">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ornare vitae nunc non iaculis. Nam dictum vitae magna at imperdiet. Cras tincidunt purus in nunc laoreet auctor. Curabitur ac commodo sem, quis tempus sem. Integer ligula dolor, luctus et bibendum eu, iaculis eu dolor. Aliquam auctor purus ipsum, quis consectetur est tincidunt at. Proin dignissim commodo arcu vitae consectetur.</p>
          <p>Sed vitae purus nec purus tempor sagittis. Maecenas gravida tincidunt maximus. Mauris pretium augue hendrerit elit mollis condimentum. Pellentesque scelerisque consectetur libero quis vehicula. Vestibuludio elementum dapibus. Ut condimentum enim quam.Sed vitae purus nec purus tempor sagittis. Maecenas gravida tincidunt maximus. Mauris pretium augue hendrerit elit mollis condimentum. Pellentesque scelerisque consectetur libero quis vehicula. Vestibuludio elementum dapibus. Ut condimentum enim quam.</p>
        </div>
        <!-- END  RIGHT-->
      </div>
    </div>
  </div>
  <!-- END: REFERENCE-->
  @include('front.includes.home-logo')
  <!-- END: HOME LOGO-->
  @include('front.includes.block')
  <!-- END: BLOCK-->
</div>
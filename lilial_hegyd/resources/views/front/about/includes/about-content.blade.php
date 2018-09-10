<div class="blk-main-content">
  <div class="blk-slider blk-page-banner"><img src="{{ asset('front/uploads/Visuel_video@2x.jpg') }}" alt="">
    <!-- IMG FOR PC-->
    <div style="background-image: url({{$actual_link}}/front/uploads/Visuel_video@2x.jpg)" class="banner-thumb"></div>
    <!-- IMG FOR MOBILE-->
    <div class="page-banner-info">
      <h1 class="ttl">Qui sommes-nous ?</h1><i style="background-image: url({{$actual_link}}/front/uploads/icons/ico-play.png)" class="ico"></i>
    </div>
  </div>
  <!-- END: BANNER-->
  <div class="home-about blk-page-desc">
    <div class="container">
      <h2 class="blk-title">Présentation</h2>
      <div class="about-txt text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ornare vitae nunc non iaculis. Nam dictum vitae magna at imperdiet. Cras tincidunt purus in nunc laoreet auctor. Curabitur ac commodo sem, quis tempus sem. Integer ligula dolor, luctus et bibendum eu, iaculis eu dolor. Aliquam auctor purus ipsum, quis consectetur est tincidunt at. Proin dignissim commodo arcu vitae consectetur.</div>
    </div>
  </div>
  <!-- END: DESC-->
  <div class="info-grid history clearfix">
    <div class="w50"><img src="{{ asset('front/uploads/man_pic@2x.jpg') }}" alt="">
      <!-- IMG FOR PC-->
    </div>
    <div class="w50">&nbsp;</div>
    <div class="info-wrap">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-sm-12 info-img"> <img src="{{ asset('front/uploads/man_pic@2x.jpg') }}" alt=""></div>
          <!-- END : IMG FOR MOBILE-->
          <div class="col-md-6 col-sm-12 info-left"> </div>
          <!-- END : LEFT-->
          <div class="col-md-6 col-sm-12 info-right">
            <div class="info"> 
              <h2 class="blk-title">@lang('about.'. $about[0]->title)</h2>
              <div class="txt">{!!$about[0]->content!!}</div>
            </div>
          </div>
          <!-- END : RIGHT-->
        </div>
      </div>
    </div>
  </div>
  <!-- END: HISTORY-->
  <div class="blk-rating pad-80">
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-sm-6 rating-itm">
          <div class="inner">
            <h3 class="ttl sml">Nombre de produits</h3>
            <h2 class="ttl num">{{$product}}</h2>
          </div>
        </div>
        <!-- END : ITEM-->
        <div class="col-md-4 col-sm-6 rating-itm">
          <div class="inner">
            <h3 class="ttl sml">Nombre de clients</h3>
            <h2 class="ttl num">{{$client}}</h2>
          </div>
        </div>
        <!-- END : ITEM-->
        <div class="col-md-4 col-sm-6 offset-md-0 offset-sm-3 rating-itm">
          <div class="inner">
            <h3 class="ttl sml">Nombre d'abonnés</h3>
            <h2 class="ttl num">{{$userSup}}</h2>
          </div>
        </div>
        <!-- END : ITEM-->
      </div>
    </div>
  </div>
  <!-- END: RATING-->
  <div class="user-list">
    <div class="info-grid clearfix">
      <div class="w50">&nbsp;</div>
      <div class="w50"> <img src="{{ asset('front/uploads/bureauequipe.png') }}" alt="">
        <!-- IMG FOR PC-->
      </div>
      <div class="info-wrap">
        <div class="container">
          <div class="row">
            <div class="col-md-6 col-sm-12 info-img"> <img src="{{ asset('front/uploads/bureauequipe.png') }}" alt=""></div>
            <!-- END : IMG FOR MOBILE-->
            <div class="col-md-6 col-sm-12 info-left">
              <div class="info"> 
                <h2 class="blk-title">@lang('about.'. $about[1]->title)</h2>
              <div class="txt">{!!$about[1]->content!!}</div>
              </div>
            </div>
            <!-- END : LEFT-->
            <div class="col-md-6 col-sm-12 info-right">&nbsp;</div>
            <!-- END : RIGHT-->
          </div>
        </div>
      </div>
    </div>
    <!-- END-->
    <div class="info-grid clearfix">
      <div class="w50"><img src="{{ asset('front/uploads/medecinpatient.png') }}" alt="">
        <!-- IMG FOR PC-->
      </div>
      <div class="w50">&nbsp;</div>
      <div class="info-wrap">
        <div class="container">
          <div class="row">
            <div class="col-md-6 col-sm-12 info-img"> <img src="{{ asset('front/uploads/medecinpatient.png') }}" alt=""></div>
            <!-- END : IMG FOR MOBILE-->
            <div class="col-md-6 col-sm-12 info-left">&nbsp;</div>
            <!-- END : LEFT-->
            <div class="col-md-6 col-sm-12 info-right">
              <div class="info"> 
                <h2 class="blk-title">@lang('about.'. $about[2]->title)</h2>
              <div class="txt">{!!$about[2]->content!!}</div>
              </div>
            </div>
            <!-- END : RIGHT-->
          </div>
        </div>
      </div>
    </div>
    <!-- END-->
    <div class="info-grid clearfix">
      <div class="w50">&nbsp;</div>
      <div class="w50"> <img src="{{ asset('front/uploads/coloplast.png') }}" alt="">
        <!-- IMG FOR PC-->
      </div>
      <div class="info-wrap">
        <div class="container">
          <div class="row">
            <div class="col-md-6 col-sm-12 info-img"> <img src="{{ asset('front/uploads/coloplast.png') }}" alt=""></div>
            <!-- END : IMG FOR MOBILE-->
            <div class="col-md-6 col-sm-12 info-left">
              <div class="info"> 
                <h2 class="blk-title">@lang('about.'. $about[3]->title)</h2>
              <div class="txt">{!!$about[3]->content!!}</div>
            </div>
            <!-- END : LEFT-->
            <div class="col-md-6 col-sm-12 info-right">&nbsp;</div>
            <!-- END : RIGHT-->
          </div>
        </div>
      </div>
    </div>
    <!-- END-->
  </div>
  <!-- END: USER LIST-->
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
<div class="home-news pad-80">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-sm-12 nw-left">
        <div class="nw-logo"><img src="{{ asset('front/uploads/logo-lilial.png') }}" alt=""></div>
        <!-- END-->
        <div class="nw-group">
          <div class="line"><img src="{{ asset('front/uploads/line_news.png') }}" alt=""></div>
          <div class="blk-desc">Ut convallis turpis nibh, at scelerisque tortor ullamcorper sed. Nullam commodo nibh volutpat, varius quam sed, molestie justo. Suspendisse sagittis scelerisque magna nec elementum. Nullam venenatis pharetra tortor non pellentesque. Nullam ut ante tempor,</div>
          <!-- END-->
          <div class="nw-type nw-small">
            <div class="row">
              <div class="col-md-6 col-sm-6 tp-left"><a href="{{ url('/club') }}" class="tp-inner"><i style="background-image: url(' {{ asset('/front/uploads/icons/bikini_icon@2x.png') }} ')" class="ico"></i>
                  <h3 class="ttl">Lingerie pour patients stomisés</h3>
                  <div class="blk-arr"><i class="fa fa-long-arrow-right"></i></div></a></div>
              <!-- END : LEFT-->
              <div class="col-md-6 col-sm-6 tp-right"><a href="{{ url('/club') }}" class="tp-inner"><i style="background-image: url(' {{ asset('/front/uploads/icons/mode_icon@2x.png') }} ')" class="ico"></i>
                  <h3 class="ttl">Mode pour personne assise</h3>
                  <div class="blk-arr"><i class="fa fa-long-arrow-right"></i></div></a></div>
              <!-- END : RIGHT-->
            </div>
          </div>
          <!-- END-->
          <div class="nw-tour nw-small">
            <div class="row">
              <div class="col-md-4 col-sm-6 tour-itm"><a href="{{ url('/club') }}"><i style="background-image: url(' {{ asset('/front/uploads/icons/ico-wheel.png') }} ')" class="ico"></i>
                  <h3 class="ttl">Aide à la mobilité</h3>
                  <div class="txt">Véhicules adaptés, fauteuils actifs ou de sport</div></a></div>
              <!-- END : ITEM-->
              <div class="col-md-4 col-sm-6 tour-itm"><a href="{{ url('/club') }}"><i style="background-image: url(' {{ asset('/front/uploads/icons/ico-tour.png') }} ')" class="ico"></i>
                  <h3 class="ttl">Tourisme</h3>
                  <div class="txt">Hébergement adapté et bonnes adresses</div></a></div>
              <!-- END : ITEM-->
              <div class="col-md-4 col-sm-12 tour-itm"><a href="{{ url('/club') }}"><i style="background-image: url(' {{ asset('/front/uploads/icons/ico-loisir.png') }} ')" class="ico"></i>
                  <h3 class="ttl">Loisirs et découvertes</h3>
                  <div class="txt">Activités adaptées : karting, FTT, parapente…</div></a></div>
              <!-- END : ITEM-->
            </div>
          </div>
          <!-- END-->
          <div class="nw-join"><a href="{{ url('/club') }}" class="btn btn-green">Rejoindre le club</a></div>
        </div>
      </div>
      <!-- END : LEFT-->
      <div class="col-md-6 col-sm-12 nw-right">
        <div class="nw-list">
          <div class="row">
            @if(count($plans))
              <?php $i = 0; ?>
              @foreach($plans as $plan)
                <?php if ($i++ > 1) break; ?>

                <div class="col-md-6 col-sm-6 nw-item"><a href="{{ url('/club/plans/'.$plan->slug) }}" class="inner">
                    <figure class="nw-img"><img src="{{ $plan->media() }}" alt=""></figure>
                    <div class="nw-info">
                      <div class="author"> <span>{{$plan->author->username}}</span></div>
                      <h3 class="nw-ttl">{{str_limit($plan->title, 38)}}</h3>
                      <div class="txt">{{ str_limit(strip_tags($plan->content), 58)}}</div>
                      <div class="blk-arr"><span>Lire la suite</span><i class="fa fa-long-arrow-right"></i></div>
                    </div></a></div>
              @endforeach
            @endif
          </div>
        </div>
        <!-- END-->
        <div class="nw-list nw-list-slider">
          @if(count($plans))
            @foreach($plans as $plan)
            <div class="nw-item"><a href="{{ url('/club/plans/'.$plan->slug) }}" class="inner">
              <figure class="nw-img"><img src="{{ $plan->media() }}" alt=""></figure>
              <div class="nw-info">
                <div class="author"> <span>{{$plan->author->username}}</span></div>
                <h3 class="nw-ttl">{{str_limit($plan->title, 38)}}</h3>
                <div class="txt">{{str_limit($plan->content, 58)}}</div>
                <div class="blk-arr"><span>Lire la suite</span><i class="fa fa-long-arrow-right"></i></div>
              </div></a>
            </div>
            @endforeach
          @endif
          <!--  END : ITEM-->
        </div>
        <!-- END : SLIDE NEWS MOBILE-->
        <div class="lil-fanpage">
            <div class="fb-page" data-href="https://www.facebook.com/liliantintorioficial" data-tabs="timeline" data-width="540" data-height="356" data-small-header="true" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="false"><blockquote cite="https://www.facebook.com/liliantintorioficial" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/liliantintorioficial">Lilian Tintori</a></blockquote></div>
        </div>
        <!-- END-->
        @widget('newsletterWidget')
      </div>
      <!-- END : RIGHT-->
    </div>
  </div>
</div>
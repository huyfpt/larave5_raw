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
              <div class="col-md-6 col-sm-6 tp-left"><a href="#" class="tp-inner"><i style="background-image: url('{{$actual_link}}/front/uploads/icons/bikini_icon@2x.png')" class="ico"></i>
                  <h3 class="ttl">Lingerie pour patients stomisés</h3>
                  <div class="blk-arr"><i class="fa fa-long-arrow-right"></i></div></a></div>
              <!-- END : LEFT-->
              <div class="col-md-6 col-sm-6 tp-right"><a href="#" class="tp-inner"><i style="background-image: url('{{$actual_link}}/front/uploads/icons/mode_icon@2x.png')" class="ico"></i>
                  <h3 class="ttl">Mode pour personne assise</h3>
                  <div class="blk-arr"><i class="fa fa-long-arrow-right"></i></div></a></div>
              <!-- END : RIGHT-->
            </div>
          </div>
          <!-- END-->
          <div class="nw-tour nw-small">
            <div class="row">
              <div class="col-md-4 col-sm-6 tour-itm"><a href="#"><i style="background-image: url('{{$actual_link}}/front/uploads/icons/ico-wheel.png')" class="ico"></i>
                  <h3 class="ttl">Aide à la mobilité</h3>
                  <div class="txt">Véhicules adaptés, fauteuils actifs ou de sport</div></a></div>
              <!-- END : ITEM-->
              <div class="col-md-4 col-sm-6 tour-itm"><a href="#"><i style="background-image: url('{{$actual_link}}/front/uploads/icons/ico-tour.png')" class="ico"></i>
                  <h3 class="ttl">Tourisme</h3>
                  <div class="txt">Hébergement adapté et bonnes adresses</div></a></div>
              <!-- END : ITEM-->
              <div class="col-md-4 col-sm-12 tour-itm"><a href="#"><i style="background-image: url('{{$actual_link}}/front/uploads/icons/ico-loisir.png')" class="ico"></i>
                  <h3 class="ttl">Loisirs et découvertes</h3>
                  <div class="txt">Activités adaptées : karting, FTT, parapente…</div></a></div>
              <!-- END : ITEM-->
            </div>
          </div>
          <!-- END-->
          <div class="nw-join"><a href="#" class="btn btn-green">Rejoindre le club</a></div>
        </div>
      </div>
      <!-- END : LEFT-->
      <div class="col-md-6 col-sm-12 nw-right">
        <div class="nw-list">
          <div class="row">
            @if(count($plans))
              @foreach($plans as $plan)
                <div class="col-md-6 col-sm-6 nw-item"><a href="#" class="inner">
                    <figure class="nw-img"><img src="{{ $plan->media() }}" alt=""></figure>
                    <div class="nw-info">
                      <div class="author"> <span>{{$plan->author->username}}</span></div>
                      <h3 class="nw-ttl">{{str_limit($plan->title, 38)}}</h3>
                      <div class="txt">{{str_limit($plan->content, 58)}}</div>
                      <div class="blk-arr"><span>Lire la suite</span><i class="fa fa-long-arrow-right"></i></div>
                    </div></a></div>
              @endforeach
            @endif
          </div>
        </div>
        <!-- END-->
        <div class="nw-list nw-list-slider">
          <div class="nw-item"><a href="#" class="inner">
              <figure class="nw-img"><img src="{{ asset('front/uploads/news_1.png') }}" alt=""></figure>
              <div class="nw-info">
                <div class="author"> <span>Mathieu Debrou</span></div>
                <h3 class="nw-ttl">41ème Congrès de la SIFUD-PP</h3>
                <div class="txt">Lilial vous donne rendez-vous le 30, 31 Mai et 1er Juin </div>
                <div class="blk-arr"><span>Lire la suite</span><i class="fa fa-long-arrow-right"></i></div>
              </div></a></div>
          <!--  END : ITEM-->
          <div class="nw-item"><a href="#" class="inner">
              <figure class="nw-img"><img src="{{ asset('front/uploads/news_2.png') }}" alt=""></figure>
              <div class="nw-info">
                <div class="author"> <span>Mathieu Debrou 1</span></div>
                <h3 class="nw-ttl">Après un accident qui m’a rendu tétraplégique…</h3>
                <div class="txt">Je me suis engagé dans un projet ambitieux développer la pratique </div>
                <div class="blk-arr"><span>Lire la suite</span><i class="fa fa-long-arrow-right"></i></div>
              </div></a></div>
          <!--  END : ITEM-->
          <div class="nw-item"><a href="#" class="inner">
              <figure class="nw-img"><img src="{{ asset('front/uploads/news_1.png') }}" alt=""></figure>
              <div class="nw-info">
                <div class="author"> <span>Mathieu Debrou</span></div>
                <h3 class="nw-ttl">41ème Congrès de la SIFUD-PP</h3>
                <div class="txt">Lilial vous donne rendez-vous le 30, 31 Mai et 1er Juin </div>
                <div class="blk-arr"><span>Lire la suite</span><i class="fa fa-long-arrow-right"></i></div>
              </div></a></div>
          <!--  END : ITEM-->
        </div>
        <!-- END : SLIDE NEWS MOBILE-->
        <div class="lil-fanpage"><img src="{{ asset('front/uploads/fanpage.png') }}" alt=""></div>
        <!-- END-->
        <div class="lil-subscription">
          <div class="row">
            <div class="col-md-4 col-sm-12 sub-title">
              <h3 class="ttl">Recevez par mail les dernières nouvelles du Club Lilial</h3>
            </div>
            <!-- END : TITLE-->
            @widget('BlockNewsletter')
            <!-- END : FORM-->
          </div>
        </div>
        <!-- END-->
      </div>
      <!-- END : RIGHT-->
    </div>
  </div>
</div>

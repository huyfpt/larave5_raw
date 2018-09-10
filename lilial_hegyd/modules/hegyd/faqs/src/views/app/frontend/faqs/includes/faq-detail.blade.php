<div class="blk-main-content">
  <div class="product-detail-info pad-80">
    <div class="container">
      <h1 class="prod-detail-ttl">{{ $faq->title }}</h1>
      <div class="row">
        <div class="col-md-12 col-sm-12 prod-info-right">
          <div class="inner">
            <div class="reference bt-30"><span>Date de publication :&nbsp;</span>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $faq->created_at)->format('d/m/Y') }}
            </div>
            {{-- <a href="#" class="btn btn-green add_cart bt-30">Besoin d'aide ?</a> --}}
            <div class="desc bt-30">
              {!!$faq->content!!}
            </div>
            <div class="desc bt-30">
              <img src="{{ $faq->media() }}" alt="">
            </div>
            <div class="desc bt-30">
              <span>Date de début de publication :&nbsp;</span>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $faq->start_at)->format('d/m/Y') }}
            </div>
            <div class="desc bt-30">
              <span>Date de fin de publication :&nbsp;</span>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $faq->end_at)->format('d/m/Y') }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('front.includes.home-logo')
  <!-- END: HOME LOGO-->
  @include('front.includes.block')
  <!-- END: BLOCK-->
</div>
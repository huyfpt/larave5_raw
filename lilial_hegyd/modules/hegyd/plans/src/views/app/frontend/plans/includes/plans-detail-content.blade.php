<div class="blk-main-content">
  @include('front.includes.hotline')
  <!-- END : HOTLINE-->
  <div class="product-list-wrap pad-80">
    <div class="product-content">
      <div class="container">
        <span>{!! $plan->content !!}</span>
      </div>
    </div>
    <div class="product-seo pad-80">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <span>
              <h4>{{ $plan->meta_title }}</h4>
              <p>{{ $plan->meta_description }}</p>
            </span>
          </div>
          <div class="col-sm-6">
            <figure class="prod-img"><img src="{{ asset($plan->media('visual', $type=3, $width=338)) }}" width="338" class="img-responsive"></figure>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END: PRODUCT LIST-->
  @include('front.includes.home-logo')
  <!-- END: HOME LOGO-->
  @include('front.includes.block')
  <!-- END: BLOCK-->
</div>
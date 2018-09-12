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
          @widget('BlockSeo')
      </div>
    </div>
  </div>
  <!-- END: PRODUCT LIST-->
  @widget('BlockLogo')
  <!-- END: HOME LOGO-->
  @include('front.includes.block')
  <!-- END: BLOCK-->
</div>
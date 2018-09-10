<div class="blk-main-content">
  @include('front.includes.hotline')
  <!-- END : HOTLINE-->
  <div class="container">
    <div class="product-list-wrap pad-80">
      <div class="container">
        {{--<h2 class="blk-title">Nos plans urologie<span>Découvez plus de {{ $plans->lastPage() * 15 }} références plans</span></h2>--}}
        <div class="product-list">
          <div class="row">
            @foreach($plans as $item)
            <div class="prod-item col-md-4 col-sm-6"><a href="{{ url('/club/plans/'.$item->slug) }}" class="prod-inner">
                <figure class="prod-img"><img src="{{ asset($item->media('visual', $type=3, $width=338)) }}" width="338" class="img-responsive"></figure>
                <div class="prod-info">
                  <div class="prod-cat">{{ $item->category->name }}</div>
                  <div class="prod-author">{{ (!empty($item->author->firstname) && !empty($item->author->lastname)) ? $item->author->firstname.' '.$item->author->lastname : 'pas de données' }}</div>
                  <div class="prod-date">{{ !empty($item->created_at) ? date('d/m/Y', strtotime($item->created_at)) : 'pas de données' }}</div>
                  <h3 class="prod-ttl">{{ $item->title }}</h3>
                  <div class="txt">{!! $item->content !!}</div>
                  <div class="blk-arr"><span>voir le plan</span><i class="fa fa-long-arrow-right"></i></div>
                </div></a>
              </div>
              @endforeach
            <!-- END : ITEM-->
          </div>
        </div>
        <!-- END -->
        
        <div class="prod-pagination">
          {{ $plans->links('front.includes..pagination', ['link_limit' => 3]) }}
        </div>
        <!-- END : PAGINATION-->
      </div>
    </div>
  </div>
  <!-- END: PRODUCT LIST-->
  @include('front.includes.home-logo')
  <!-- END: HOME LOGO-->
  @include('front.includes.block')
  <!-- END: BLOCK-->
</div>
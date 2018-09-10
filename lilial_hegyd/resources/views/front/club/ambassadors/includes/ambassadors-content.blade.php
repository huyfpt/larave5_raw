<div class="product-list-wrap pad-80">
  <div class="container">
    <h2 class="blk-title">Nos produits urologie<span>Découvez plus de 3000 références produits</span></h2>
    <div class="product-list">
      <div class="row">
        @if(!empty($ambassadors))
          @foreach($ambassadors as $item)
            <div class="prod-item col-md-4 col-sm-6">
              <a href="{{ url('/club/ambassadors/'.$item->user_id) }}" class="prod-inner">
                <figure class="prod-img"><img src="{{ asset($item->media('visual', $type=4, $width=313)) }}" alt=""></figure>
                <div class="prod-info">
                  <!-- <div class="prod-cat">{{ $item->category->name }}</div>
                  <div class="prod-author">{{ $item->author->firstname.' '.$item->author->lastname }}</div>
                  <div class="prod-date">{{ date('d/m/Y', strtotime($item->created_at)) }}</div> -->
                  <h3 class="prod-ttl">{{ $item->user->name }}</h3>
                  <!-- <div class="txt">{!! $item->content !!}</div> -->
                  <div class="blk-arr"><span>voir le produit</span><i class="fa fa-long-arrow-right"></i></div>
                </div>
              </a>
            </div>
          @endforeach
        @endif
      </div>
    </div>
    <!-- END -->
    <div class="prod-pagination">
      {{ $ambassadors->links('front.includes..pagination', ['link_limit' => 3]) }}
    </div>
    <!-- END : PAGINATION-->
  </div>
</div>
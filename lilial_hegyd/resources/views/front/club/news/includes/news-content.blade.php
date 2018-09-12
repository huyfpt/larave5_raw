<div class="product-list-wrap pad-80">
  <div class="container">
    <h2 class="blk-title">Nos produits urologie<span>Découvez plus de 3000 références produits</span></h2>
    <div class="product-list">
      <div class="row">
        @if(!empty($news))
          @foreach($news as $item)
            <div class="prod-item col-md-4 col-sm-6">
              <a href="{{ url('/club/actualites/'.$item->slug) }}" class="prod-inner">
                <figure class="prod-img"><img src="{{ asset($item->media('visual', $type=4, $width=313)) }}" alt=""></figure>
                <div class="prod-info">
                  <div class="prod-cat">{{ $item->category->name }}</div>
                  <div class="prod-author">{{ (!empty($item->author->firstname) && !empty($item->author->lastname)) ? $item->author->firstname.' '.$item->author->lastname : 'pas de données' }}</div>
                  <div class="prod-date">{{ (!empty($item->start_at) && !empty($item->end_at)) ? date('d/m/Y', strtotime($item->start_at)).' - '.date('d/m/Y', strtotime($item->end_at)) : 'pas de données' }}</div>
                  <h3 class="prod-ttl">{{ $item->name }}</h3>
                  <div class="txt">{!! $item->content !!}</div>
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
      {{ $news->links('front.includes..pagination', ['link_limit' => 3]) }}
    <!-- END : PAGINATION-->
  </div>
</div>
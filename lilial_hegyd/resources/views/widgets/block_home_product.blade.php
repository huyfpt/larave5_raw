    <h2 class="blk-title">Nos produits<span>Découvez plus de 3000 références produits</span></h2>
    <div class="product-list">
      
      @foreach ($data as $item)
      <div class="prod-item">
            <a href="{{ url('/produits/'. $item->slug) }}" class="prod-inner">
              <figure class="prod-img"><img src="{!! $item->media('visual', 2, 279) !!}" alt="{{ $item->name }}"></figure>
              <div class="prod-info">
                <div class="prod-cat">{{ $item->category->name }}</div>
                <div class="prod-author">{{ $item->brand->name }}</div>
                <h3 class="prod-ttl">{{ $item->name }}</h3>
                <div class="txt">{{ str_limit(strip_tags($item->description), $limit = 75, $end = '...') }}</div>
                <div class="blk-arr"><span>voir le produit</span><i class="fa fa-long-arrow-right"></i></div>
              </div>
            </a>
      </div>
      @endforeach
      <!-- END : ITEM-->

    </div>
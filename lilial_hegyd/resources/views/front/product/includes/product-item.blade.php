        <div class="prod-item col-md-4 col-sm-6">
            <a href="{{ url('/produits/'. $item->slug) }}" class="prod-inner">
              <figure class="prod-img"><img src="{!! $item->media('visual', 2, 279) !!}" alt="{{ $item->name }}"></figure>
              <div class="prod-info">
                <div class="prod-cat">{{ $item->category->name }}</div>
                <div class="prod-author">{{ $item->brand->name }}</div>
                <h3 class="prod-ttl">{{ $item->name }}</h3>
                <div class="txt">{{ str_limit($item->description, $limit = 75, $end = '...') }}</div>
                <div class="blk-arr"><span>voir le produit</span><i class="fa fa-long-arrow-right"></i></div>
              </div>
            </a>
        </div>
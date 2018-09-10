<div class="blk-main-content">

  @include('front.includes.hotline')
  <!-- END : HOTLINE-->

  <div class="home-about prod-about pad-60">
    <div class="container">
      <div class="about-txt">
        <h3 class="ttl">Introduction de la catégorie</h3>
        {!! $category->description !!}
      </div>
    </div>
  </div>
  <!-- END: ABOUT-->

  <div class="product-filter pad-80">
    <div class="container">
      <h2 class="blk-title">Catégorie principale</h2>
      <div class="filter-tags">
        @foreach ($childCategory as $slug=>$cate)
          <a href="{!! url('produits/category/'.$slug) . '#product-list' !!}">{{ $cate }}</a>
        @endforeach
      </div>
      <!-- END : TAGS-->
    </div>
  </div>
  <div class="hp-form-group filter-form pad-60">
    <div class="container">
      {!! Form::model(null, ['method' => 'GET', 'class' => 'hp-form']) !!}
        <input type="text" name="keyword" placeholder="Rechercher une référence produit" class="ipt">
        <button class="hp-btn"><i class="ico"></i></button>
      {!! Form::close() !!}
    </div>
  </div>
  <!-- END FORM-->
  <!-- END: FILTER-->

  <div class="product-list-wrap pad-80" id="product-list">
    <div class="container">
      <h2 class="blk-title">Nos produits {!! strtolower($category->name) !!}<span>Découvez plus de 3000 références produits</span></h2>
      <div class="product-list">
        <div class="row">
          
          @foreach ($data as $item)
          <div class="prod-item col-md-4 col-sm-6"><a href="{{ url('/produits/'. $item->slug) }}" class="prod-inner">
              <figure class="prod-img"><img src="{!! $item->media('visual', 2, 279) !!}" alt="{{ $item->name }}"></figure>
              <div class="prod-info">
                <div class="prod-cat">{{ $item->category->name }}</div>
                <div class="prod-author">{{ $item->brand->name }}</div>
                <h3 class="prod-ttl">{{ $item->name }}</h3>
                <div class="txt">{{ str_limit($item->description, $limit = 75, $end = '...') }}</div>
                <div class="blk-arr"><span>voir le produit</span><i class="fa fa-long-arrow-right"></i></div>
              </div></a></div>
          <!-- END : ITEM-->
          @endforeach

        </div>
      </div>
      <!-- END -->
      @if ($data)
      <div class="prod-pagination">
          {{ $data->appends(['keyword' => $keyword])->links('front.includes.pagination', ['link_limit' => 3]) }}
      </div>
      @endif;
      <!-- END : PAGINATION-->
    </div>
  </div>
  <!-- END: PRODUCT LIST-->
  @include('front.includes.home-logo')
  <!-- END: HOME LOGO-->
  @include('front.includes.block')
  <!-- END: BLOCK-->
</div>
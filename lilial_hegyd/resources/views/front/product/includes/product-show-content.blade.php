
@inject('uploadService', 'Hegyd\Uploads\Services\UploadService');
@inject('productService', 'Hegyd\eCommerce\Services\ProductCatalog\ProductService');


<div class="blk-main-content">
  <div class="product-detail-info pad-80">
    <div class="container">
      <h1 class="prod-detail-ttl">{{ $product->name }}</h1>
      <div class="row">
        <div class="col-md-6 col-sm-12 prod-info-left">
          <div class="inner">
            <div class="main-gallery">

              @php
                $i = 0;

                $images[$i]['thumb'] = $product->media('visual', 3, 493);
                $images[$i]['origin'] = $product->media('visual', 1);
                foreach($product->visuals()->orderBy('position')->get() as $key => $item) {
                  $i++;
                  $images[$i]['thumb'] = $uploadService->generateSrc($item, 3, 493);
                  $images[$i]['origin'] = $uploadService->generateSrc($item, 1);
                }
              @endphp

              @foreach($images as $image)
                <div data-src="{!! $image['origin'] !!}" class="gal-item"><img src="{!! $image['thumb'] !!}" alt="image"></div>
                <!-- END-->
              @endforeach

            </div>
            <!-- END : MAIN GALLERY-->
            <div class="thumb-gallery">
              @foreach ($images as $image)
                <div class="gal-item"><img src="{{ $image['thumb'] }}" alt="thumb"></div>
              @endforeach
            </div>
            <!-- END : MAIN GALLERY-->
          </div>
        </div>
        <!-- END : LEFT-->
        <div class="col-md-6 col-sm-12 prod-info-right">
          <div class="inner">
            <div class="reference bt-30"><span>Référence :&nbsp;</span>{{ $product->reference }}</div>
              <a href="{{ url('/contact') }}" class="btn btn-green add_cart bt-30" data-toggle="tooltip" title="Dispositif soumis à prescription médicale, pour commander ce produit contacter notre serve relation client du lundi au vendredi de 9h à 18h sans interruption.">Besoin d'aide ?</a>
            <div class="desc bt-30">
              {!! $product->description !!}
            </div>
            <div class="brand"><img src="{{ url('/app/img/logo/' .$product->brand->logo) }}" alt="logo {{ $product->brand->name }}"></div>
          </div>
        </div>
        <!-- END : RIGHT-->
      </div>
    </div>
  </div>
  <!-- END: INFO-->
  <?php $table = $productService->buildTableDeclension($product) ?>
  <div class="product-detail-table">
    <div class="container">
      <div class="table-responsive">
        <table class="table">
          <thead>
            
            <tr>
              @foreach ($table['columns'] as $column)
              <th>{{ mb_strtoupper($column) }}</th>
              @endforeach
            </tr>

          </thead>
          <tbody> 
            
            @foreach ($table['rows'] as $cells)
            <tr>
              @foreach ($cells as $value)
                <td>{{ $value }}</td>
              @endforeach
            </tr>
            @endforeach

          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- END: TABLE-->

  @if (count($related))
  <div class="product-access pad-80">
    <div class="container">
      <h2 class="blk-title">Produits associés<span>Découvez tous nos produits similaires</span></h2>
      <div class="product-list">

        @foreach ($related as $item) 
          <div class="prod-item"><a href="{{ url('/produits/'. $item->slug) }}" class="prod-inner">
            <figure class="prod-img"><img src="{{ $item->media('visual', 2, 279) }}" alt="{{ $item->name }}"></figure>
            <div class="prod-info">
              <div class="prod-cat">{{ $item->category->name }}</div>
              <div class="prod-author">{{ $item->brand->name }}</div>
              <h3 class="prod-ttl">{{ $item->name }}</h3>
              <div class="txt">{{ str_limit($item->description, $limit = 75, $end = '...') }}</div>
              <div class="blk-arr"><span>voir le produit</span><i class="fa fa-long-arrow-right"></i></div>
            </div></a>
          </div>
          <!-- END : ITEM-->
        @endforeach

      </div>
      <!-- END-->
    </div>
  </div>
  <!-- END: accessories-->
  @endif

  @widget('BlockSeo')

  @include('front.includes.home-logo')
  <!-- END: HOME LOGO-->
  @include('front.includes.block')
  <!-- END: BLOCK-->
</div>
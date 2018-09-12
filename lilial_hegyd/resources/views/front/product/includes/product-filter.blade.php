      <?php $keyword = !empty($keyword) ? $keyword : '' ?>
      <div class="product-filter pad-80">
        <div class="container">
          <h2 class="blk-title">Catégorie principale</h2>
          <div class="filter-tags">
            @foreach ($childCategory as $cate)
              <a href="{!! url('produits/category/'.$cate['slug']) !!}" class="{{ request()->is('produits/category/'.$cate['slug']) ? 'active' : '' }}" >{{ $cate['name'] }}</a>
            @endforeach
          </div>
        </div>
      </div>

      <div class="hp-form-group filter-form pad-60">
        <div class="container">
          {!! Form::open(['method' => 'POST', 'class' => 'hp-form', 'url' => '/produits/search']) !!}
            <input type="text" name="keyword" id="keyword" placeholder="Rechercher une référence produit" class="ipt" value="{{ $keyword }}">
            <button class="hp-btn"><i class="ico"></i></button>
          {!! Form::close() !!}
        </div>
      </div>
      <!-- END FORM-->

@section('js')
  <script src="{{ asset('vendor/hegyd/ecommerce/js/products/search.js') }}"></script>
@endsection
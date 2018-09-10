@extends('layouts.front')

@section('title')
  <title>Lilial French Product</title>
@endsection

@section('css')
@endsection

@section('content')
  <section class="main">
    @include('front.product.includes.product-slider')
    <!-- END: HOME SLIDER-->

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

      @include('front.product.includes.product-filter')
      <!-- END: FILTER-->

      <div class="product-list-wrap pad-80" id="product-list">
        <div class="container">
          <h2 class="blk-title">Nos produits {!! strtolower($category->name) !!}<span>Découvez plus de 3000 références produits</span></h2>
          <div class="product-list">
            <div class="row">
              
              @foreach ($data as $item)
              
                @include('front.product.includes.product-item')

              @endforeach

            </div>
          </div>
          <!-- END -->
          @if ($data)
          <div class="prod-pagination">
              {{ $data->appends(['keyword' => $keyword])->links('front.includes.limit_links') }}
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

  </section>
@endsection

@section('js')
@endsection
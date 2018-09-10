<div class="product-list" id="faqs_content">
  <div class="row">
    @if(count($faqs))
    @foreach($faqs as $faq)
      
      <div class="prod-item col-md-4 col-sm-6"> <!-- <a href="#" class="prod-inner"> -->
        <figure class="prod-img"><a href="{{ url('/faqs/'.$faq->slug) }}" class="prod-inner"><img src="{{ $faq->media() }}" alt=""></a></figure>
        <div class="prod-info">
          <div class="row">
            <div class="col-md-8 col-sm-6">{{ $faq->category->label }}</div>
            <div class="col-md-4  col-sm-4">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $faq->start_at)->format('d/m/Y') }}</div>
          </div>
          {{-- <div class="prod-author">BBraun</div> --}}
          <h3 class="prod-ttl">{{ $faq->title }}</h3>
          <div class="txt">{!! str_limit($faq->content, 90) !!}</div>
          {{-- <div class="blk-arr"><span>voir le produit</span><i class="fa fa-long-arrow-right"></i></div> --}}
        </div><!-- </a> -->
      </div>
        
    @endforeach
    @else
      <div class="col-md-12">
          <div class="alert alert-danger text-center">
              @lang('hegyd-faqs::faqs_categories.label.no_faqs')
          </div>
      </div>
    @endif
  </div>
</div>
<!-- END -->
{{-- <div class="prod-pagination"><span class="current">1</span><a class="pager">2</a><a class="pager">3</a><a class="pager nextpostslink">suivant  </a></div> --}}
{{-- <div class="prod-pagination">@include('hegyd-faqs::frontend.faqs.includes.pagination', ['paginator' => $faqs, 'link_limit' => 3])</div> --}}
<div class="prod-pagination">{!! $faqs->links() !!}</div>
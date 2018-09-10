<div class="col-md-4 col-sm-12 hp-left">
	<div class="inner pad-80">
		<h2 class="blk-title">Besoin d’informations ?<span>Consultez notre FAQ</span></h2>
		<div class="hp-form-group">
			<div class="form-group hp-form">
				{{-- <form>
					<input type="text" placeholder="Rechercher " class="ipt" name="category">
					<button class="hp-btn"><i class="ico"></i></button>
				</form> --}}
			</div>
		  <!-- END -->
		  @if(count($faqCategories))
		  @foreach($faqCategories as $category)
			<div class="form-group"><a href="{{$category->url()}}" class="cat-item d-table">
				<div class="d-table-cell">
					<img class="ico" src="{{ $category->media() }}" alt="">
					{{-- <div style="background-image: url('{{$actual_link}}/front/uploads/icons/uro_icon@2x.png')" class="ico"></div> --}}
				</div>
				<div class="d-table-cell">
					<h3 class="ttl">{{$category->label}}</h3>
				</div><i class="fa fa-plus"></i></a></div>
			@endforeach
		  @endif
		  <!-- END -->
	<!-- END -->
	<div class="blk-arr"><a href="/faqs"><span>Découvrez notre FAQ</span><i class="fa fa-long-arrow-right"></i></a></div>
	</div>
</div>
</div>
<div class="blk-main-content">
  <div class="hotline-side">
    <div class="hotline-desc"> <span class="sml">RAPPEL</span><span class="lrg">GRATUIT !</span></div><a href="#" class="hot-click"><i style="background-image: url('{{$actual_link}}/front/uploads/icons/ico-phone-w.png')" class="ico"></i></a>
  </div>
  <!-- END : HOTLINE-->

  <!-- END: ABOUT-->
  <div class="product-list-wrap pad-80" id="faqs">
    <div class="container">
      <div class="product-filter pad-80">
        <div class="container">
          <h2 class="blk-title">{{$heading}}</h2>
          <div id="faqs_btn_group" class="filter-tags">
            @include('hegyd-faqs::app.frontend.faqs.includes.list_categories')
          </div>
          <!-- END : TAGS-->
        </div>
      </div>
      @include('hegyd-faqs::app.frontend.faqs.includes.list_faqs')

      <!-- END : PAGINATION-->
    </div>
  </div>
  <!-- END: PRODUCT LIST-->
  @include('front.includes.home-logo')
  <!-- END: HOME LOGO-->
  @include('front.includes.block')
  <!-- END: BLOCK-->
  <div id="cover-spin"></div>
</div>

@section('js')
<script>
  var currentUrl = $(location).attr('href');
  console.log(currentUrl);
  $(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    $('#cover-spin').show(0);
    var urlStr = $(this).attr('href').split('faqs?')[1];
    var urlArr = urlStr.split('&');

    var categoryId, page;
    if (urlArr.length == 1) {
      page = urlArr[0].split('=')[1];
      categoryId = 0;
    } else {
      categoryId = urlArr[0].split('=')[1];
      page = urlArr[1].split('=')[1];
      
    }
    getFaqs(page, categoryId);
  });

  function getUrl(page, urlParam) {
    if (urlParam && urlParam !== 0) {
      return '/faqs?category_id=' + urlParam + '&page=' + page;
    }
    return '/faqs?page=' + page;
  }
  function getFaqs(page, category_id) {
    var url = getUrl(page, category_id); 

    $.ajax({
      url: url,
      type: 'GET',
    })
    .done(function(data) {
      $('#cover-spin').hide();
      $('.prod-pagination').remove();
      $('#faqs_content').html(data);
    });
  }
  $(document).on('click', '#faqs_btn_group a', function (e) {
    e.preventDefault();
    $('#cover-spin').show(0);
    if ($('#faqs_btn_group a').hasClass('faqs-active')) {
      console.log('yep!');
      $('#faqs_btn_group a').removeClass('faqs-active');
    }
    var aTag = $(this);
    aTag.addClass('faqs-active');
    var category = $(this).attr('data-id');
    $.ajax({
      url: '/faqs',
      type: 'GET',
      data: { category }
    }).done(function (data) {
      $('#cover-spin').hide();
      $(aTag).addClass('category-active');
      $('.prod-pagination').remove();
      $('#faqs_content').html(data);
      // $('#faqs_btn_group a').css({
      //   'color': ''
      // });
    })

  })
</script>
@endsection
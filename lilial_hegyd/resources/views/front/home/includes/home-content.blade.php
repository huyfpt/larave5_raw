<div class="blk-main-content">
  @include('front.includes.hotline')
  <!-- END : HOTLINE-->
  <div class="home-about pad-60">
    <div class="container">
      <div class="line line1"><img src="{{ asset('front/uploads/line_2.png') }}" alt=""></div>
      <div class="line line2"><img src="{{ asset('front/uploads/line_1.png') }}" alt=""></div>
      <h2 class="blk-title">Lilial : des services à l’écoute de nos clients</h2>
      <div class="blk-desc">Suspendisse eu sagittis mauris. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</div>
      <div class="about-txt">
        <h3 class="ttl">Un accompagnement partout en France</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ornare vitae nunc non iaculis. Nam dictum vitae magna at imperdiet. Cras tincidunt purus in nunc laoreet auctor. Curabitur ac commodo sem, quis tempus sem. Integer ligula dolor, luctus et bibendum eu, iaculis eu dolor. Aliquam auctor purus ipsum, quis consectetur est tincidunt at. Proin dignissim commodo arcu vitae consectetur.</p>
        <p>Sed vitae purus nec purus tempor sagittis. Maecenas gravida tincidunt maximus. Mauris pretium augue hendrerit elit mollis condimentum. Pellentesque scelerisque consectetur libero quis vehicula. Vestibuludio elementum dapibus. Ut condimentum enim quam.</p>
      </div>
      <div class="about-list">
        <div class="row">
          <div class="col-md-7 col-sm-12 ab-left">
            <ul class="lst">
              <li class="clearfix">
                <div class="ab-icon"><span>1</span><i style="background-image: url('{{$actual_link}}/front/uploads/icons/ico-text.png')" class="ico"></i></div>
                <div class="ab-info">
                  <h4 class="sml-ttl">Prescription médicale</h4>
                  <div class="txt">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ornare vitae nunc non iaculis. Nam dictum vitae magna at imperdiet. Cras tincidunt purus i</div>
                </div>
              </li>
              <li class="clearfix">
                <div class="ab-icon"><span>2</span><i style="background-image: url('{{$actual_link}}/front/uploads/icons/ico-member.png')" class="ico"></i></div>
                <div class="ab-info">
                  <h4 class="sml-ttl">Commande avec le conseiller</h4>
                  <div class="txt">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ornare vitae nunc non iaculis. Nam dictum vitae magna at imperdiet. Cras tincidunt purus i</div>
                </div>
              </li>
              <li class="clearfix">
                <div class="ab-icon"><span>3</span><i style="background-image: url('{{$actual_link}}/front/uploads/icons/ico-gift.png')" class="ico"></i></div>
                <div class="ab-info">
                  <h4 class="sml-ttl">Livraison</h4>
                  <div class="txt">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ornare vitae nunc non iaculis. Nam dictum vitae magna at imperdiet. Cras tincidunt purus i</div>
                </div>
              </li>
              <li class="clearfix">
                <div class="ab-icon"><span>4</span><i style="background-image: url('{{$actual_link}}/front/uploads/icons/ico-tele.png')" class="ico"></i></div>
                <div class="ab-info">
                  <h4 class="sml-ttl">Télétransmission administrative</h4>
                  <div class="txt">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ornare vitae nunc non iaculis. Nam dictum vitae magna at imperdiet. Cras tincidunt purus i</div>
                </div>
              </li>
            </ul>
          </div>
          <!-- END : LEFT-->
          <div class="col-md-5 col-sm-12 ab-right"><a href="#" data-toggle="modal" data-target="#myVideo" class="ab-video"><img src="{{ asset('front/uploads/video_bg.png') }}" alt="">
              <div class="video_click"><i class="fa fa-play-circle-o"></i></div></a></div>
          <!-- END : RIGHT-->
        </div>
      </div><!-- Modal -->
      <div id="myVideo" tabindex="-1" role="dialog" aria-labelledby="myVideo" aria-hidden="true" class="modal fade">
        <div class="modal-dialog">
          <div class="modal-content"><span data-dismiss="modal" aria-label="Close" class="close"><i class="ico ico-close d-inline-block"></i></span>
            <div class="modal-body"> 
              <iframe src="https://www.youtube.com/embed/PcNRXlhc0nc?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen class="youtube_player_iframe"></iframe>
            </div>
          </div>
        </div>
      </div>
      <!-- END: VIDEO-->
    </div>
  </div>
  <!-- END: HOME ABOUT-->
  <!-- Begin plans block -->
  @include('front.home.includes.plans-block')
  <!-- END: HOME NEWS-->
  <div class="home-product">
    <div class="container">
      <div class="row">
        @include('front.home.includes.faq-block')

        <!-- END : LEFT-->
        <div class="col-md-8 col-sm-12 hp-right">
          <div class="inner pad-80">

            @widget('BlockHomeProduct')

            <!-- END-->
            <div class="hp-form-group">
              <div class="row">
                <div class="col-md-6 col-sm-12">

                  {!! Form::open(['method' => 'POST', 'class' => 'hp-form', 'id'=> 'search_block', 'url' => '/produits/search']) !!}
                    <input type="text" placeholder="Rechercher " class="ipt" name="keyword">
                    <button class="hp-btn"><i class="ico"></i></button>
                  {!! Form::close() !!}

                </div>
                <!-- END-->
                <div class="col-md-6 col-sm-12">
                  <div class="blk-arr"><a href="{{ url('/produits') }}"><span>Voir tous les produits</span><i class="fa fa-long-arrow-right"></i></a></div>
                </div>
                <!-- END-->
              </div>
              <!-- END -->
            </div>
          </div>
        </div>
        <!-- END : RIGHT-->
      </div>
    </div>
  </div>

  @widget('BlockLogo')
  <!-- END: Block LOGO-->
  
  @include('front.includes.block')
  <!-- END: BLOCK-->
</div>
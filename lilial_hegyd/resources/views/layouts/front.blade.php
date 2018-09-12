<!DOCTYPE html>
<!--[if IE 8]><html lang="en" class="no-js ie ie8"><![endif]-->
<!--[if IE 9]><html lang="en" class="no-js ie ie9"><![endif]-->
<!--[if gt IE 9]><!-->
<html lang="en" class="no-js">
  <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    @yield('title')
    <meta name="title" content="@yield('meta_title')">
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"><!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <link rel="shortcut icon" href="{{ asset('front/uploads/icons/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">
    <!-- <link rel="stylesheet" href="{{ asset('front/css/style.min.css') }}"> -->
    @yield('css')
  </head>

  <body class="body-css">
    <header class="header-wrap">
      <div class="container">
        <div class="row">
          <div class="col-logo col-md-2 col-sm-12"><a href="{{ route('frontend.homes.index') }}"><img src="{{ asset('front/uploads/logo.png') }}" alt="logo lilial"></a></div>
          <!-- END : LOGO-->
          <div class="col-menu col-md-10 col-sm-12">
            <div class="d-inline-block grp-menu">
              <ul class="menu d-inline-block">
                <li>
                    <a href="{{ url('/produits/category/urologie') }}" class="{{ request()->is('produits/category/urologie') ? 'active' : '' }}">Urologie</a>
                </li>
                <li>
                    <a href="{{ url('/produits/category/stomatherapie') }}" class="{{ request()->is('produits/category/stomatherapie') ? 'active' : '' }}">Stomathérapie</a>
                </li>
                <li>
                    <a href="{{ url('/produits/category/cicatrisation') }}" class="{{ request()->is('produits/category/cicatrisation') ? 'active' : '' }}">Cicatrisation</a>
                </li>
                <li>
                    <a href="{{ url('/qui-sommes-nous') }}" class="{{ request()->is('qui-sommes-nous') ? 'active' : '' }}">Qui sommes-nous ?</a>
                </li>
                <li>
                    <a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}">Contact</a>
                </li>
                <li>
                    <a href="{{ url('/faqs') }}" class="{{ request()->is('faqs') ? 'active' : '' }}">FAQ</a>
                </li>
              </ul>
              <!-- END : MENU-->

              <div class="d-inline-block hd-club-wrap"><a href="{{ url('/club') }}" class="hd_club {{ request()->is('club*') ? ' active' : '' }}">Le Club Lilial</a>
                <ul class="sub-menu">
                  <li><a href="{{ url('/club/plans') }}">Les bons plans</a></li>
                  <li><a href="{{ url('/club/actualites') }}">La communauté</a></li>
                 </ul>
               </div>

              <a href="#" class="hd_search d-inline-block"><i class="ico ico-search"></i>
              </a>

              <div class="search-wrap">
                {!! Form::open(['method' => 'POST', 'class' => 'hp-form', 'id' => 'search_top', 'url' => '/produits/search']) !!}
                  <button class="btn-search"><i class="ico ico-search"></i></button>
                  <input type="text" name="keyword" id="keyword_top" placeholder="Rechercher " class="ipt ipt-normal">
                {!! Form::close() !!}
              </div>
            </div>
          </div><a href="#" class="hd_menu d-inline-block"><i class="ico ico-bars"></i></a>
          <!-- END : COL MENU-->
        </div>
      </div>
    </header>



    <!-- END : HEADER-->

    @yield('content')
    <!-- END : CONTENT-->
    
    @inject('setting', 'App\Services\Content\SettingService')
    @include('front.includes.footer')
    @include('front.includes.cookies')

    <script src="{{ asset('front/js/libs.min.js') }}"></script>
    <script src="{{ asset('front/js/jquery.ba-throttle-debounce.min.js') }}"></script>
    <script src="{{ asset('front/js/plugins/jquery.clickOut.min.js') }}"></script>
    <script src="{{ asset('front/js/plugins/modal.min.js') }}"></script>
    <script src="{{ asset('front/js/plugins/slick.min.js') }}"></script>
    <script src="{{ asset('front/js/contact.js') }}"></script>
    <script src="{{ asset('front/js/plugins/jquery.autocomplete.min.js') }}"></script>
    <script src="{{ asset('front/js/plugins/bootstrap-checkbox.min.js') }}"></script>
    <script src="{{ asset('front/js/plugins/lightgallery.min.js') }}"></script>
    <script src="{{ asset('front/js/plugins/jquery.hoverDelay.js') }}"></script>
    {{-- <script src="{{ asset('front/js/start.min.js') }}"></script> --}}
    <script src="{{ asset('front/js/start.js') }}"></script>
    <script src="{{ asset('front/js/custom.js') }}"></script>

    @yield('js')

    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = 'https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v3.1&appId=272968703141432';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    
  </body>
</html>
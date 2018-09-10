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
  @php $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]"; @endphp
  <body class="body-css">
    <header class="header-wrap">
      <div class="container">
        <div class="row">
          <div class="col-logo col-md-2 col-sm-12"><a href="{{ url('/') }}"><img src="{{ asset('front/uploads/logo.png') }}" alt=""></a></div>
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
                    <a href="{{ url('/about/qui-sommes-nous') }}" class="{{ request()->is('about/qui-sommes-nous') ? 'active' : '' }}">À propos de Lilial</a>
                </li>
                <li>
                    <a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}">Contact</a>
                </li>
                <li>
                    <a href="{{ url('/faqs') }}" class="{{ request()->is('faqs') ? 'active' : '' }}">FAQ</a>
                </li>
              </ul>
              <!-- END : MENU--><a href="{{ url('/club') }}" class="hd_club d-inline-block{{ request()->is('club*') ? ' active' : '' }}">Le Club Lilial</a><a href="#" class="hd_search d-inline-block"><i class="ico ico-search"></i></a>
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
    <script src="{{ asset('front/js/plugins/jquery.autocomplete.min.js') }}"></script>
    {{-- <script src="{{ asset('front/js/cookies.js') }}"></script> --}}
    <script src="{{ asset('front/js/plugins/bootstrap-checkbox.min.js') }}"></script>
    <script src="{{ asset('front/js/plugins/lightgallery.min.js') }}"></script>
    {{-- <script src="{{ asset('front/js/start.min.js') }}"></script> --}}
    <script src="{{ asset('front/js/start.js') }}"></script>
    @yield('js')
  </body>
</html>
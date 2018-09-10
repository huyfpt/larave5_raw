<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
@include('auth.includes.head')
<body>
<!-- Preloader -->
<div class="preloader">
    <div class="cssload-speeding-wheel"></div>
</div>

<section id="wrapper" class="login-register">
    <div class="login-logo  animated fadeInUp">
        <img src="{!! $visualLogoLarge !!}" alt="logo" class="" />
    </div>
    <div class="login-box animated fadeInUp">

        <div class="white-box">
            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @yield('content')
        </div>
    </div>
</section>
@include('auth.includes.scripts')
</body>
</html>
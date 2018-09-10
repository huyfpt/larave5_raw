<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
@include('app.includes.head')
<body>
@include('app.includes.preloader')
<section id="wrapper" class="login-register">
    <div class="login-logo  animated fadeInUp">
        <img src="{!! $visualLogoLarge !!}" alt="logo" class="" />
    </div>
    <div class="login-box animated fadeInUp">
        <div class="white-box text-center">
            <h1>500</h1>
            <h3 class="text-uppercase">@lang('errors.500.title')</h3>
            <p class="text-muted m-t-30 m-b-30">@lang('errors.500.description')</p>
            <a href="/" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">@lang('errors.500.button')</a>
        </div>
    </div>
</section>

@include('app.includes.scripts')
</body>
</html>
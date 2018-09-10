<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
@include('app.includes.head')
<body>
@include('app.includes.preloader')

<div id="wrapper">
    @include('app.includes.header')
    @include('app.includes.menu_left')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">

            @include('app.includes.breadcrumb')

            @if($flash = app(\App\Services\Notification\NotificationService::class)->getFlashNotifications())
                @if(isset($flash['text']) && isset($flash['type']))
                    <div class="alert alert-{{$flash['type']}}">{!! $flash['text'] !!}</div>
                @endif
            @endif
            @if($alert = app(\App\Services\Notification\NotificationService::class)->getAlertNotifications())
                @if(isset($alert['text']) && isset($alert['type']))
                    <div class="hide" name="flash-alert" data-title="" data-content="{{$alert['text']}}" data-type="{{$alert['type']}}"></div>
                @endif
            @endif
        
            <div class="row">
                @yield('content')
            </div>

        </div>
        <!-- /.container-fluid -->
        @include('app.includes.footer')
    </div>
    <!-- /#page-wrapper -->
</div>
@include('app.includes.scripts')
</body>
</html>

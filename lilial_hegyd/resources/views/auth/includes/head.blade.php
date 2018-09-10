<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{config('app.name')}} - @yield('title')</title>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://www.w3schools.com/lib/w3data.js"></script>

    <script>try{Typekit.load({ async: true });}catch(e){}</script>

    <link rel="shortcut icon" href="{!! $visualFavicon !!}" />
    <link rel="apple-touch-icon" href="{!! $visualLogo !!}" />

    @include('auth.includes.stylesheets')
    @include('app.includes.colors')
</head>
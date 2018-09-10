{{--Global stylesheets for app--}}

{!! Html::style('/vendor/bower/bootstrap/dist/css/bootstrap.min.css') !!}
{!! Html::style('/vendor/bower/animate.css/animate.min.css') !!}
{!! Html::style('/vendor/bower/font-awesome/web-fonts-with-css/css/fontawesome-all.min.css') !!}
{!! Html::style('/vendor/bower/metisMenu/dist/metisMenu.min.css') !!}
{!! Html::style('/vendor/bower/jsgrid/dist/jsgrid-theme.min.css') !!}

{{--{!! Html::style('/app/css/app.css') !!}--}}

{!! Html::style('/app/fonts/linea-icons/linea.css') !!}
{!! Html::style('/app/fonts/themify-icons/themify-icons.css') !!}
{!! Html::style('/app/fonts/gh-icons/style.css') !!}


<link href="/tmp/css/style.css" rel="stylesheet" />
<!-- color CSS -->
<link href="/tmp/css/colors/default-dark.css" id="theme"  rel="stylesheet" />

<link href="/tmp/css/add.css" rel="stylesheet" />

@stack('stylesheets')
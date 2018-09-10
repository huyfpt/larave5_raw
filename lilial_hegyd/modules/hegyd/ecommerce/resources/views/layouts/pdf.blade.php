<html>
<head>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i');

        @page {
            margin-bottom: 75px;
            margin-top: 125px;
        }

        body {
            font-family: 'Open Sans', arial,helvetica, sans-serif;
            font-size: 13px;
        }

        #header {
            position: fixed;
            left: 0px;
            top: -120px;
            right: 0px;
            height: 120px;
        }

        #footer {
            border-top: 2px solid #191B1E;
            padding-top: 15px;
            position: fixed;
            left: 0px;
            bottom: -75px;
            right: 0px;
            height: 75px;
            text-align: center;
        }
        .pull-right{
            float: right;
        }
        #footer .page:after {
            /*content: "Page " counter(page);*/
        }
        .text-center {
            text-align: center;
        }
        .text-left {
            text-align: left;
        }
        .text-right {
            text-align: right;
        }

        @yield('style')
    </style>
    <title>{{ isset($title) ? $title : '' }}</title>
<body>
<div id="header">
    @yield('header')
</div>

<div id="footer">
    @yield('footer')
</div>


@include('hegyd-ecommerce::pdf.includes.footer')
<div id="content">
    @yield('content')
</div>

</body>
</html>
{{--Global scripts for app--}}
{!! Html::script('/vendor/bower/jquery/dist/jquery.min.js') !!}
<!-- {!! Html::script('/vendor/bower/jquery-ui/jquery-ui.min.js') !!} -->
{!! Html::script('/vendor/bower/jquery-ui/jquery-ui.js') !!}

{!! Html::script('/vendor/bower/bootstrap/dist/js/bootstrap.min.js') !!}

{!! Html::script('/vendor/bower/metisMenu/dist/metisMenu.min.js') !!}

{!! Html::script('/vendor/bower/jquery.toaster/jquery.toaster.js') !!}
{!! Html::script('/vendor/bower/sweetalert2/dist/sweetalert2.all.min.js') !!}

{!! Html::script('/vendor/bower/toastr/toastr.min.js') !!}
{!! Html::script('/app/js/modernizr-object-fit.js') !!}

{!! Html::script('/app/js/waves.js') !!}
{!! Html::script('/app/js/hegyd.js') !!}


@stack('scripts')
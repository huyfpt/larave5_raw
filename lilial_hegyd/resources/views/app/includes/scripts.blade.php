{{--Global scripts for app--}}
{!! Html::script('/vendor/bower/jquery/dist/jquery.min.js') !!}

{!! Html::script('/vendor/bower/bootstrap/dist/js/bootstrap.min.js') !!}

<!-- {!! Html::script('/vendor/bower/jquery-ui/jquery-ui.min.js') !!} -->
{!! Html::script('/app/vendor/bower/jquery-ui/jquery-ui.js') !!}

{!! Html::script('/vendor/bower/jquery-form/jquery.form.js') !!}

{!! Html::script('/vendor/bower/jquery-validation/dist/jquery.validate.js') !!}
{!! Html::script('/vendor/bower/jquery-validation/src/localization/messages_fr.js') !!}

{!! Html::script('/vendor/bower/metisMenu/dist/metisMenu.min.js') !!}
{!! Html::script('/vendor/bower/jquery-slimscroll/jquery.slimscroll.min.js') !!}
{!! Html::script('/vendor/bower/counterup/jquery.counterup.js') !!}
{!! Html::script('/vendor/bower/gauge.js/dist/gauge.min.js') !!}
{!! Html::script('/vendor/bower/jquery.toaster/jquery.toaster.js') !!}
<!-- {!! Html::script('/vendor/bower/sweetalert2/dist/sweetalert2.all.min.js') !!} -->
{!! Html::script('/vendor/bower/switchery/dist/switchery.min.js') !!}
{!! Html::script('/app/vendor/bower/sweetalert/dist/sweetalert.min.js') !!}

{!! Html::script('/vendor/bower/toastr/toastr.min.js') !!}
{!! Html::script('/app/js/modernizr-object-fit.js') !!}

{!! Html::script('/app/js/waves.js') !!}
{{--{!! Html::script('/app/js/custom.js') !!}--}}
{{--{!! Html::script('/app/js/dashboard3.js') !!}--}}
{!! Html::script('/app/js/notifications.js') !!}

{!! Html::script('/app/js/hegyd.js') !!}
{!! Html::script('/app/js/backend.js') !!}
{!! Html::script('/app/js/leave.js') !!}
{!! Html::script('/app/js/menu-left.js') !!}





{{--{!! Html::script('../js/gauge.js') !!}--}}

{{--<script type="text/javascript">--}}
	{{--var opts = {--}}
	  {{--lines: 12,--}}
	  {{--angle: 0,--}}
	  {{--lineWidth: 0.3,--}}
	  {{--pointer: {--}}
	    {{--length: 0.9,--}}
	    {{--strokeWidth: 0.035,--}}
	    {{--color: '#000000'--}}
	  {{--},--}}
	  {{--limitMax: 'false', --}}
	  {{--percentColors: [[0.0, "#4bc34e" ], [0.50, "#f9c802"], [1.0, "#ff8400"]], // !!!!--}}
	  {{--strokeColor: '#E0E0E0',--}}
	  {{--generateGradient: true--}}
	{{--};--}}



	{{--var target = document.getElementById('gauge-keypoint');--}}
	{{--var gauge = new Gauge(target).setOptions(opts);--}}
	{{--gauge.maxValue = 3000;--}}
	{{--gauge.animationSpeed = 32;--}}
	{{--gauge.set(2250);--}}

	{{--var target = document.getElementById('gauge-keypoint-2');--}}
	{{--var gauge = new Gauge(target).setOptions(opts);--}}
	{{--gauge.maxValue = 3000;--}}
	{{--gauge.animationSpeed = 32;--}}
	{{--gauge.set(2250);--}}
	{{--var target = document.getElementById('gauge-keypoint-3');--}}
	{{--var gauge = new Gauge(target).setOptions(opts);--}}
	{{--gauge.maxValue = 3000;--}}
	{{--gauge.animationSpeed = 32;--}}
	{{--gauge.set(2250);--}}
	{{--var target = document.getElementById('gauge-keypoint-4');--}}
	{{--var gauge = new Gauge(target).setOptions(opts);--}}
	{{--gauge.maxValue = 3000;--}}
	{{--gauge.animationSpeed = 32;--}}
	{{--gauge.set(2250);--}}
	{{--var target = document.getElementById('gauge-keypoint-5');--}}
	{{--var gauge = new Gauge(target).setOptions(opts);--}}
	{{--gauge.maxValue = 3000;--}}
	{{--gauge.animationSpeed = 32;--}}
	{{--gauge.set(2250);--}}
	{{--var target = document.getElementById('gauge-keypoint-6');--}}
	{{--var gauge = new Gauge(target).setOptions(opts);--}}
	{{--gauge.maxValue = 3000;--}}
	{{--gauge.animationSpeed = 32;--}}
	{{--gauge.set(2250);--}}


{{--</script>--}}

{{--<script type="text/javascript">--}}

{{--$('#listTask .item').click( function(){--}}
    {{--if ( $(this).hasClass('current') ) {--}}
        {{--$(this).removeClass('current');--}}
    {{--} else {--}}
        {{--$('#listTask .item.current').removeClass('current');--}}
        {{--$(this).addClass('current');    --}}
    {{--}--}}
{{--});--}}
{{--</script>--}}

<script type="text/javascript">
	if ( ! Modernizr.objectfit ) {
	  $('.post__image-container').each(function () {
	    var $container = $(this),
	        imgUrl = $container.find('img').prop('src');
	    if (imgUrl) {
	      $container
	        .css('backgroundImage', 'url(' + imgUrl + ')')
	        .addClass('compat-object-fit');
	    }  
	  });
	}
</script>
{{--<script type="text/javascript">--}}
{{--jQuery(document).ready(function() {--}}
	{{--jQuery('.toggle-nav').click(function(e) {--}}
		{{--jQuery(this).toggleClass('active');--}}
		{{--jQuery('.sidebar-nav ul').toggleClass('active');--}}

		{{--e.preventDefault();--}}
	{{--});--}}
{{--});--}}
{{--</script>--}}



@stack('scripts')






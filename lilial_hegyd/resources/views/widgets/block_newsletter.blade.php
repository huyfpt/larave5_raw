
<a data-toggle="modal" data-target="#modal-newsletter">
    <i class="fa fa-paper-plane-o" aria-hidden="true"></i> Newsletter
</a>

@include('widgets.includes.newsletter-modal')

<script src="{{ asset('front/js/libs.min.js') }}"></script>
<script>

jQuery( document ).ready(function() {
	$('#save_newsletter').click(function(){
		var form = $('#newsletter_frm');
    	var url = form.attr('action');
    	$('i.fa-circle-o-notch').parent().removeClass('hide');
    	$('#save_newsletter').prop('disabled', true);
		$.ajax({
           type: "POST",
           url: url,
           data: form.serialize(),
           success: function(data) {
           	    $('i.fa-circle-o-notch').parent().addClass('hide');
                var success = '<div class="alert alert-success">Merci de vous joindre à nous.</div>';
                $('.modal-body').children().hide();
                $('.modal-body').append(success);
                setTimeout(function() {
			       $("#modal-newsletter").modal('hide');
			    }, 900);
           },
           error: function (request, status, error) {
		        if (typeof request.responseText !== "undefined") {
		        	var error = JSON.parse(request.responseText);
		        	if (error.hasOwnProperty('first_name')) {
		        		var firstNameMsg = '<ul><li>';
		        		firstNameMsg += error.first_name[0];
		        		firstNameMsg += '</li></ul>';
		        		$("#first_name").show().html(firstNameMsg);
		        	} else {
		        		$('#first_name').hide();
		        	}
		        	if (error.hasOwnProperty('last_name')) {
		        		var lastNameMsg = '<ul><li>';
		        		lastNameMsg += error.last_name[0];
		        		lastNameMsg += '</li></ul></span>';
		        		$("#last_name").show().html(lastNameMsg);
		        	} else {
		        		$('#last_name').hide();
		        	}
		        	if (error.hasOwnProperty('email')) {
		        		var emailMsg = '<ul><li>';
		        		emailMsg += error.email[0];
		        		emailMsg += '</li></ul></span>';
		        		$('#newsletters_email').show().html(emailMsg);
		        	} else {
		        		$('#newsletters_email').hide();
		        	}
		        }
		        $('i.fa-circle-o-notch').parent().addClass('hide');
    			$('#save_newsletter').prop('disabled', false);
		   }
         });
 	});
});	
</script>

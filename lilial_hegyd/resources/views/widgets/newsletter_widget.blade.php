<div class="lil-subscription newsletters-subs">
  <div class="row newsletters-body">
    <div class="col-md-4 col-sm-12 sub-title">
      <h3 class="ttl">Recevez par mail les dernières nouvelles du Club Lilial</h3>
    </div>
    <!-- END : TITLE-->
    <div class="col-md-8 col-sm-12 sub-form">
      {!! Form::open(['route' => config('hegyd-faqs.routes.frontend.newsletters.create-from-form'), 'method' => 'post', 'class' => 'form-horizontal', 'id' => 'newsletters_simple']) !!}
        <input type="text" placeholder="Adresse e-mail" class="sub-ipt" name="email">
        <button class="sub-btn" type="button" id="add_newsletter">Inscription</button>
        <span class="help-block" id="error_msg"></span>
      {!! Form::close() !!} 
    </div>
    <!-- END : FORM-->
  </div>
</div>
<!-- END-->

<script src="{{ asset('front/js/libs.min.js') }}"></script>
<script>
  $('#add_newsletter').click(function(e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    $('#add_newsletter').prop('disabled', true);
    var form = $('#newsletters_simple');
    var url = form.attr('action');
    $.ajax({
      type: "POST",
      url: url,
      data: form.serialize(),
        success: function(data) {
          $('#add_newsletter').prop('disabled', false);
          if (data.errors) {
            var error = data.errors;
            var emailMsg = '<ul><li>';
            emailMsg += error.email[0];
            emailMsg += '</li></ul></span>';
            $('#error_msg').show().html(emailMsg);
          } else {
            $('.newsletters-body').children().hide();
            var success = '<div class="alert alert-success" role="alert">';
            success += '<h4 class="alert-heading">S\'abonner avec succès</h4>';
            success += '<p>';
            success += data.message;
            success += '</p>';
            $('.newsletters-subs').append(success);
            setTimeout(function() {
              $(".newsletters-subs").fadeOut(3000);
            }, 900);
            $('.newsletters-body').children().show();
          }
        },
        error: function (request, status, error) {
          
        }
    });
    return false;
  });
jQuery( document ).ready(function() {

}); 
</script>

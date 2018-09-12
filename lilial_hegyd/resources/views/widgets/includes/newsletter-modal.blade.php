<div class="modal fade" id="modal-newsletter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered newsletter-content" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Newsletter</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        {!! Form::open(['route' => config('hegyd-faqs.routes.frontend.newsletters.create-from-modal'), 'method' => 'post', 'class' => 'form-horizontal', 'id' => 'newsletter_frm']) !!}
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Nom:</label>
            <input type="text" class="form-control" name="first_name">
            <span class="help-block" id="first_name"></span>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Prénom:</label>
            <input type="text" class="form-control" name="last_name">
            <span class="help-block" id="last_name"></span>
          </div>
          <div class="form-group {!! Form::hasError('email', $errors) !!}">
            <label for="recipient-name" class="col-form-label">E-mail:</label>
            <input type="text" class="form-control" name="email">
            <span class="help-block" id="newsletters_email"></span>
          </div>
          <div class="form-group">

            <input class="form-check-input" type="checkbox" value="checked" id="default_newsletter" checked name="active">
            <label class="form-check-label" for="default_newsletter">
            J’accepte de recevoir des communications du Club Lilial
            </label>

          </div>
          {!! Form::close() !!} 
          <div class="col-md-12 hide text-center">
                <i class="fa fa-circle-o-notch fa-spin text-danger fa-2x"></i>
          </div> 
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="save_newsletter">Send message</button>
      </div>
    </div>
  </div>
</div>


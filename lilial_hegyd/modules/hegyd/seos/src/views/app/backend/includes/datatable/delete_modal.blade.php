
{{-- modal for deletion --}}
<div class="modal fade" tabindex="-1" role="dialog" id="delete-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">@Lang('app.delete')</h4>
      </div>
      <div class="modal-body">
        <p>@Lang('app.delete_question')</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">@Lang('app.no')</button>
        <button type="button" id="delete-btn-confirmation" class="btn btn-danger">@Lang('app.yes')</button>
      </div>
    </div>
  </div>
</div>

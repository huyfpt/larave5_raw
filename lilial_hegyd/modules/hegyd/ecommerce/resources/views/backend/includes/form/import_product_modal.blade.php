
{{-- modal for import excel --}}

<div class="modal fade" tabindex="-1" role="dialog" id="import-product-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">@Lang('hegyd-ecommerce::products.title.import')</h4>
      </div>
      <div class="modal-body">
          {!! Form::open(array('url' => 'admin/referentiel/produits/import-zip','method'=>'POST','files'=>'true', 'id'=>'form-import')) !!}
          <div class="row">
             <div class="col-xs-12">
                  <div class="form-group">
                      <input type="file" name="zip_file" class="form-control" required="" accept=".zip" id="zip_file">
                  </div>

                  <div id="progress" class="hidden">
                    <div id="bar"></div>
                    <div id="percent">0%</div>
                  </div>
                  <div class="alert alert-danger import-error hidden" role="alert">
                  
                  </div>
                  <div id="result">
                  </div>

              </div>
          </div>
      </div>
      <div class="modal-footer">
          {!! Form::submit('Importer',['class'=>'btn btn-danger', 'id'=> 'submit-import']) !!}
          <button type="button" class="btn btn-default" data-dismiss="modal">@Lang('hegyd-ecommerce::products.buttons.cancel')</button>
          {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>

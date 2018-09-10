
{{-- modal for import excel --}}
<div class="modal fade" tabindex="-1" role="dialog" id="import-excel-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">@Lang('clients.import.excel')</h4>
      </div>
      <div class="modal-body">
          {!! Form::open(array('url' => 'admin/clients/import/excel','method'=>'POST','files'=>'true')) !!}
          <div class="row">
             <div class="col-xs-12">
                  <div class="form-group">
                      <input type="file" name="excel_file" class="form-control" required="" accept=".xlsx, .xls">
                  </div>
              </div>
          </div>
      </div>
      <div class="modal-footer">
          {!! Form::submit('Importer',['class'=>'btn btn-danger']) !!}
          <button type="button" class="btn btn-default" data-dismiss="modal">@Lang('clients.import.cancel')</button>
          {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-category" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::model($category, ['route' => config('hegyd-ecommerce.routes.backend.category.create-from-modal'), 'method' => 'post', 'class' => 'form-horizontal']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">@lang('hegyd-ecommerce::categories.title.new')</h4>
            </div>
            <div class="modal-body">
                <div class="form-group {!! Form::hasError('active', $errors) !!}">
                    <div class="col-md-2">
                        <label class="control-label">@lang('hegyd-ecommerce::categories.fields.active')</label>
                    </div>
                    <div class="col-md-10">
                        {!! Form::checkbox('active', 1, 1, ['class' => 'switcheryable']) !!}
                        {!! Form::errorMsg('active', $errors) !!}
                    </div>
                </div>
                <div class="form-group {!! Form::hasError('name', $errors) !!}">
                    <div class="col-md-2">
                        <label class="control-label">@lang('hegyd-ecommerce::categories.fields.name') <i class="required-field">*</i></label>
                    </div>
                    <div class="col-md-10">
                        {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                        {!! Form::errorMsg('name', $errors) !!}
                    </div>
                </div>
                <div class="form-group {!! Form::hasError('parent_id', $errors) !!}">
                    <div class="col-md-2">
                        <label class="control-label">@lang('hegyd-ecommerce::categories.fields.parent_category')</label>
                    </div>
                    <div class="col-md-10">
                        {!! Form::select('parent_id', $tree_category, null, ['class' => 'form-control']) !!}
                        {!! Form::errorMsg('parent_id', $errors) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('app.buttons.close')</button>
                <button type="submit" class="btn btn-primary">@lang('app.buttons.save')</button>
            </div>
            {!! Form::close() !!}

            <div class="col-md-12 loading hide text-center">
                <i class="fa fa-circle-o-notch fa-spin text-danger fa-5x"></i>
            </div>
        </div>
    </div>
</div>
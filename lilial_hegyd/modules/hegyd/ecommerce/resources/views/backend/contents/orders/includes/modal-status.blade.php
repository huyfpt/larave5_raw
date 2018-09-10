@inject('orderService', 'Hegyd\eCommerce\Services\eCommerce\OrderService')
<div id="modal-status" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">@lang('hegyd-ecommerce::orders.title.update_status')</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::model($model, ['route' => [config('hegyd-ecommerce.routes.backend.order.update'), $model->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
                        <div class="form-group"><label class="col-md-3 control-label">@lang('hegyd-ecommerce::orders.fields.status') <i class="required-fields">*</i></label>
                            <div class="col-md-8">
                                {!! Form::select('status', $orderService->status(), $model->status, [
                                    'class' => 'form-control',
                                    'required',
                                    ]
                                )!!}
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group">
                            <div class="col-md-5">@lang('app.required_fields')</div>
                            <div class="col-md-7">
                                <div class="actions pull-right">
                                    <button type="submit" name="save" class="btn btn-primary save-btn">
                                        @lang('app.buttons.save')
                                    </button>
                                </div>
                            </div>
                        </div>
                        {!!Form::close()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
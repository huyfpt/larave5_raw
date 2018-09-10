<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">{!! $title !!}</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($model, ['route' => $route, 'method' => $method, 'class' => 'form-horizontal']) !!}
            <div class="form-group"><label class="col-md-3 control-label">Produit <i class="required-fields">*</i></label>
                <div class="col-md-8">
                    @if($model->exists)
                        {!! Form::text('product_id', $model->product->title(), [
                            'class' => 'form-control',
                            'required',
                            'readonly',
                            ]
                        )!!}
                    @else
                        {!! Form::select('product_id', [], null, [
                            'id'    => 'search-product',
                            'class' => 'form-control',
                             'href' => route(config('hegyd-ecommerce.routes.backend.order.lines.search-product'), [$order]),
                            'required',
                            $model->exists ? 'readonly' : ''
                            ]
                        )!!}
                    @endif
                </div>
            </div>
            <div class="form-group"><label class="col-md-3 control-label">Quantité <i class="required-fields">*</i></label>
                <div class="col-md-8">
                    {!! Form::number('quantity', null, ['class' => 'form-control', 'required', 'min' => 1])!!}
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
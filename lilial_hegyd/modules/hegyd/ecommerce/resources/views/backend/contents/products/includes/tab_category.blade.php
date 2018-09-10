
        <div class="form-group {!! Form::hasError('category_id', $errors) !!}">
            <div class="col-md-2">
                <label class="control-label">@lang('hegyd-ecommerce::products.fields.category') <i class="required-field">*</i></label>
            </div>
            <div class="col-md-8">
                {!! Form::select('category_id', $categories, $model->category_id, ['class' => 'form-control', 'required']) !!}
                {!! Form::errorMsg('category_id', $errors) !!}
            </div>
            @if(Entrust::can(config('hegyd-ecommerce.permissions.backend.category.create')))
                <a data-toggle="modal" data-target="#modal-category" href="" class="btn btn-primary">
                    <i class="fa fa-plus" aria-hidden="true"></i> @lang('hegyd-ecommerce::categories.buttons.add')
                </a>
            @endif
        </div>
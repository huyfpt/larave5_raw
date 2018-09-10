<div class="form-group {!! Form::hasError('active', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-ecommerce::products.fields.active')</label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::checkbox('active', 1, null, ['class' => 'switcheryable']) !!}
                                {!! Form::errorMsg('active', $errors) !!}
                            </div>
                        </div>
                        <div class="form-group {!! Form::hasError('name', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-ecommerce::products.fields.name') <i class="required-field">*</i></label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                                {!! Form::errorMsg('name', $errors) !!}
                            </div>
                        </div>
                        <div class="form-group {!! Form::hasError('reference', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-ecommerce::products.fields.reference') <i class="required-field">*</i></label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::text('reference', null, ['class' => 'form-control', 'required']) !!}
                                {!! Form::errorMsg('reference', $errors) !!}
                            </div>
                        </div>

                        {{-- <div class="form-group {!! Form::hasError('price', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-ecommerce::products.fields.price') <i class="required-field">*</i></label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::number('price', null, ['class' => 'form-control', 'required', 'step' => 'any']) !!}
                                {!! Form::errorMsg('price', $errors) !!}
                            </div>
                        </div> --}}

                        <div class="form-group {!! Form::hasError('description', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-ecommerce::products.fields.description') <i class="required-field">*</i></label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::textarea('description', null, ['class' => 'form-control summernote', 'required']) !!}
                                {!! Form::errorMsg('description', $errors) !!}
                            </div>
                        </div>

                        <div class="form-group {!! Form::hasError('file_table_declension', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-ecommerce::products.fields.table_declension')</label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::file('file_table_declension', null, ['class' => 'form-control']) !!}
                                {!! Form::errorMsg('file_table_declension', $errors) !!}
                            </div>
                        </div>

                        <div class="form-group {!! Form::hasError('brand_id', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-ecommerce::products.fields.brand') <i class="required-field">*</i></label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::select('brand_id', $brands, $model->brand_id, ['class' => 'form-control', 'id' => 'field-brand']) !!}
                                {!! Form::errorMsg('brand_id', $errors) !!}
                            </div>
                        </div>

                        <div class="form-group {!! Form::hasError('brand_id', $errors) !!}">
                            <div class="col-md-2">
                                <label class="control-label">@lang('hegyd-ecommerce::products.fields.brand_logo')
                                </label>
                            </div>
                            <div class="col-md-10">
                                <?php 
                                    $logo = '';
                                    if (!empty($model->brand)) {
                                        $logo = Url('/app/img/logo/'. $model->brand->logo); 
                                    } 
                                ?>
                                <img class="file-preview-image brand_logo" src="<?= $logo ?>" />
                            </div>
                        </div>


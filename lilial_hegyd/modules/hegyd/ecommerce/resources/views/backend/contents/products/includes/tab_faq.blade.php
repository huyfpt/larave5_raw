
        <div class="form-group {!! Form::hasError('faq', $errors) !!}">
            <div class="col-md-2">
                <label class="control-label">@lang('hegyd-ecommerce::products.fields.faq')</label>
            </div>
            <div class="col-md-10">

                <select class="form-control" id="product_faq" multiple="true" name="faqs[]">
                    @if(!empty($model->faqs))
                        @foreach($model->faqs as $item)
                            <option selected="selected" value="{{$item->id}}">{{$item->title}}</option>
                        @endforeach
                    @endif
                </select>

            </div>
        </div>
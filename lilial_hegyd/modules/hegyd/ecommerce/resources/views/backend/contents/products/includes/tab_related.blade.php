
        <div class="form-group {!! Form::hasError('related', $errors) !!}">
            <div class="col-md-2">
                <label class="control-label">@lang('hegyd-ecommerce::products.fields.related')</label>
            </div>
            <div class="col-md-10">
                
                <select class="form-control" id="product_related" multiple="true" name="related[]">
                    @if(!empty($related))
                        @foreach($related as $item)
                            <option selected="selected" value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    @endif
                </select>

            </div>
        </div>
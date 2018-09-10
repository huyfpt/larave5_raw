

<?php if (!empty($list_feature)) : ?>


    <?php 
    $i = 0;
    foreach ($list_feature as $item) : ?>

        @if ($i%2 == 0) 
        <div class="form-group">
        @endif

        <?php $i++; ?>

            <div class="col-md-2">
                <label class="control-label">{{ $item->name }}</label>
            </div>
            <div class="col-md-4">
                <select class="form-control" name="feature[{{ $item->id }}]">

                    <option value="">@lang('hegyd-ecommerce::products.labels.select_values')</option>
                    @if(!empty($item->option))
                        @foreach($item->option as $option)
                            <?php 
                                $selected = '';
                                if (in_array($option->id, $feature)) {
                                    $selected = 'selected="selected"';
                                }
                            ?>
                            <option {{ $selected }} value="{{$option->id}}">{{$option->name}}</option>
                        @endforeach
                    @endif
                </select>
            </div>

        @if ($i%2 == 0) 
            </div>
        @endif

    <?php endforeach; ?>


<?php endif; ?>
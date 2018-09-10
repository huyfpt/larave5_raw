<div class="row">
    <div class="col-lg-12">
        <div class="white-box printableArea">
             <div class="pull-right">
                @if($model->status < \Hegyd\eCommerce\Models\eCommerce\Order::STATUS_ARCHIVED)
                    <a data-toggle="modal" data-target="#modal-status"  class="btn btn-default" href="#modal-status">
                        <i class="fa fa-history"></i> @lang('hegyd-ecommerce::orders.buttons.update_status')
                    </a>
                @endif
            </div>
            <h3 class="box-title">@lang('hegyd-ecommerce::orders.labels.histories')</h3>
<hr />
            <table class="table table-striped table-basket">
                <thead>
                <tr>
                    <th class="col-md-6 text-left">@lang('hegyd-ecommerce::orders.fields.histories.text')</th>
                    <th class="col-md-3">@lang('hegyd-ecommerce::orders.fields.histories.user')</th>
                    <th class="col-md-3">@lang('hegyd-ecommerce::orders.fields.histories.created_at')</th>
                </tr>
                </thead>
                <tbody>
                    @if($model->histories->count())
                        @foreach($model->histories as $history)
                            <tr>
                                <td class="text-left">{!! $history->text !!}</td>
                                <td>{{ $history->user->fullname() }}</td>
                                <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3">@lang('hegyd-ecommerce::orders.labels.no_history')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>


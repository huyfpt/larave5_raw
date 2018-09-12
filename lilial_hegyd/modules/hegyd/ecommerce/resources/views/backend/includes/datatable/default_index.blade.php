@extends(config('hegyd-ecommerce.main_layout.backend'))

@section('title')
{!! $title !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">

                <div class="ibox">
                    <div class="ibox-title">
                        <h3>{!! $title !!}</h3>
                        <div class="ibox-tools v2">

                            <div class="btn-group">

                                @if($addButton && Entrust::can($config['prefixes']['acl'] . 'create'))
                                    <a href="{!! route( $config['prefixes']['route'] . 'create') !!}"
                                       class="btn btn-primary pull-right">
                                        <i class="fa fa-plus"></i>
                                        @lang($config['prefixes']['lang'] . 'buttons.add')
                                    </a>
                                @endif

                                @foreach($moreActions as $action)
                                    @if(! isset($action['acl']) || Entrust::can($config['prefixes']['acl'] . $action['acl']))
                                            @php
                                                $route = $config['prefixes']['route'] . $action['route'];

                                                if(isset($action['complete_route']) && $action['complete_route'])
                                                {
                                                    $route = $action['route'];
                                                }

                                                $route_params = [];

                                                if(isset($action['route_params']) && is_array($action['route_params']))
                                                {
                                                    $route_params = $action['route_params'];
                                                }
                                            @endphp
                                        <a href="{!! route($route, $route_params) !!}"
                                           class="btn {{ isset($action['class']) ? $action['class'] : 'btn-default' }} pull-right">
                                            @if(isset($action['icon_class']))
                                                <i class="{{ $action['icon_class'] }}"></i>
                                            @endif
                                            @lang($config['prefixes']['lang'] . $action['label'])
                                        </a>
                                    @endif
                                @endforeach

                                @if($bulkActions && count($bulkActions))
                                    <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">
                                        @lang('app.bulk_actions')
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                    @foreach($bulkActions as $actionKey)
                                        @if(isset($config['bulk'][$actionKey]))
                                            @php
                                                $action = $config['bulk'][$actionKey];
                                            @endphp
                                            @if(isset($action['divider']) && $action['divider'])
                                                <li class="divider"></li>
                                            @endif
                                            <li>
                                                @if(strtolower($action['route']) == 'import.zip')
                                                    <a class="bulkAction import-modal"
                                                        href="#"
                                                        data-confirm="{{ isset($action['confirm']) ? $action['confirm'] : false }}"
                                                        data-confirm-title="import.zip"
                                                        data-confirm-text="{{ isset($action['text']) ? $action['text'] : false }}"
                                                        data-ajax="{{ isset($action['ajax']) ? $action['ajax'] : true }}" >
                                                        <i class="{{ $action['icon'] }}"></i> {{ $action['text'] }}
                                                    </a>
                                                @else
                                                <a class="bulkAction"
                                                   href="{{  route($config['prefixes']['route'] . $action['route']) }}"
                                                   data-confirm="{{ isset($action['confirm']) ? $action['confirm'] : false }}"
                                                   data-confirm-title="{{ isset($action['confirm-title']) ? $action['confirm-title'] : false }}"
                                                   data-confirm-text="{{ isset($action['confirm-text']) ? $action['confirm-text'] : false }}"
                                                   data-ajax="{{ isset($action['ajax']) ? $action['ajax'] : true }}" >
                                                    <i class="{{ $action['icon'] }}"></i> {{ $action['text'] }}
                                                </a>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                    </ul>
                                @endif
                            </div>

                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="ibox-content">
                        <div class="table-responsive">
                            <div class="dataTables_wrapper form-inline dt-bootstrap">
                                @include('hegyd-ecommerce::backend.includes.datatable.datatable')
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@include('app.includes.datatable.delete_modal')
@include('hegyd-ecommerce::backend.includes.form.import_product_modal')

@endsection
@push('stylesheets')
{!! Html::style('/vendor/hegyd/ecommerce/dependencies/sweetalert/dist/sweetalert.css') !!}
{!! Html::style('/vendor/hegyd/ecommerce/dependencies/toastr/toastr.min.css') !!}
{!! Html::style('/vendor/hegyd/ecommerce/css/index.css') !!}
@endpush
@push('scripts')
{!! Html::script('/vendor/hegyd/ecommerce/dependencies/sweetalert/dist/sweetalert.min.js') !!}
{!! Html::script('/vendor/hegyd/ecommerce/dependencies/toastr/toastr.min.js') !!}

{!! Html::script('/vendor/hegyd/ecommerce/js/notifications.js') !!}
{!! Html::script('/vendor/hegyd/ecommerce/js/datatable/default.js') !!}
{!! Html::script('/vendor/hegyd/ecommerce/js/datatable/bulk_actions.js') !!}
@endpush

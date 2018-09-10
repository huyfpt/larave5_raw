<table id="app-datatable" class="table table-striped table-bordered table-hover dataTables-example dataTable">
    <thead>
        <tr role="row" class="heading">
            @if(isset($bulkActions) && $bulkActions)
                <th data-sort-ignore="true"  data-row-class="" class="min-width nofilter noorder checkbox-column col-md-1">
                    @lang('app.select')
                </th>
            @endif
            @foreach ($fields as $field)
                <th data-class-row="{!! isset($field['class_row']) ? $field['class_row'] : '' !!}"
                    class="{!! isset($field['class']) ? $field['class'] : '' !!} {!! isset($field['orderable']) && !$field['orderable'] ? 'noorder' : '' !!}">
                    @lang($field['title'])
                </th>
            @endforeach
            <th data-sort-ignore="true" data-row-class="" class="min-width nofilter noorder action-column">
                @lang('app.actions')
            </th>
        </tr>
    </thead>
    <thead>
        @if(isset($filter) && $filter)
            <tr role="row" class="filter">
                {{--Actions groupées => Checkbox de sélection--}}
                @if(isset($bulkActions) && $bulkActions)
                <th data-sort-ignore="true" class="min-width checkbox-actions" rowspan="1" colspan="1">
                    <div class="checkbox checkbox">
                        <input id="select-all" name="bulk_actions" class="nofilter noorder" type="checkbox">
                        <label for="select-all"></label>
                    </div>
                </th>
                @endif

                {{--Affichage des entêtes des différents champs--}}
                @foreach ($fields as $field)
                    @if(!empty($field['filterKey']))
                        <th class="footable-visible footable-sortable footable-sorted-desc table-search">
                            @if(empty($field['disable_filter']))

                                @if (!$field['filterKey'])
                                    {{trans('app.All')}}
                                @endif

                                @if (($field['type'] == 'int' || $field['type'] == 'text'))
                                    <input type="text" class="form-control form-filter input-sm width-full" autocomplete="off"
                                           name="{!! $field['filterKey'] !!}">
                                @endif

                                @if ($field['type'] == 'bool')
                                    <select name="{!! $field['filterKey'] !!}" class="form-control form-filter input-sm width-full">
                                        <option value="">{{trans('app.All')}}</option>
                                        <option value="1">@lang('app.active')</option>
                                        <option value="0">@lang('app.inactive')</option>
                                    </select>
                                @endif

                                @if (in_array($field['type'],['select','join']))
                                    <select name="{!! $field['filterKey'] !!}" class="form-control form-filter input-sm width-full">
                                        <option value="">{{trans('app.All')}}</option>
                                        @foreach($field['list'] as $fieldValue => $fieldLabel)
                                        <option value="{{ $fieldValue }}">@lang($fieldLabel)</option>
                                        @endforeach
                                    </select>
                                @endif

                                @if ($field['type'] == 'date')
                                    <div class="input-group date col-md-5-5 col-big-5">
                                        <input type="text" class="form-control form-filter input-sm" readonly=""
                                               name="{!! $field['filterKey'] !!}_from" placeholder="@lang('app.from_date')">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </div>
                                    <div class="input-group date col-md-5-5 col-big-5">
                                        <input type="text" class="form-control form-filter input-sm" readonly=""
                                               name="{!! $field['filterKey'] !!}_to" placeholder="@lang('app.to_date')">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </div>
                                @endif
                            @endif
                        </th>
                    @else
                        <th class="footable-visible">
                        </th>
                    @endif
                @endforeach

                <th data-sort-ignore="true" class="min-width action-column" rowspan="1" colspan="1">
                    <div class="btn-group">
                        <a href="javascript:void()" alt="@lang('app.search')"
                           title="@lang('app.search')" class="btn btn-primary btn-xs">
                            <i class="fa fa-search"></i></a>
                        <a alt="@lang('app.reset')" id="btn-reset"
                           title="@lang('app.reset')" class="btn btn-default dropdown-toggle btn-xs">
                            <i class="fa fa-retweet"></i>
                        </a>
                    </div>
                </th>
            </tr>
        @endif
    </thead>
    <tbody>
    </tbody>
</table>

@push('stylesheets')
{!! Html::style('/vendor/hegyd/ecommerce/dependencies/datatables.net-dt/css/jquery.dataTables.min.css') !!}
{!! Html::style('/vendor/hegyd/ecommerce/dependencies/datatables.net-fixedheader-dt/css/fixedHeader.dataTables.min.css') !!}
{!! Html::style('/vendor/hegyd/ecommerce/dependencies/datatables.net-responsive-dt/css/responsive.dataTables.min.css') !!}

{!! Html::style('/vendor/hegyd/ecommerce/dependencies/select2/dist/css/select2.min.css') !!}

@endpush

@push('scripts')
{!! Html::script('/vendor/hegyd/ecommerce/dependencies/datatables.net/js/jquery.dataTables.min.js') !!}
{!! Html::script('/vendor/hegyd/ecommerce/dependencies/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') !!}
{!! Html::script('/vendor/hegyd/ecommerce/dependencies/datatables.net-responsive/js/dataTables.responsive.min.js') !!}

{!! Html::script('/vendor/hegyd/ecommerce/dependencies/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') !!}
{!! Html::script('/vendor/hegyd/ecommerce/dependencies/bootstrap-datepicker/dist/locales/bootstrap-datepicker.fr.min.js') !!}

{!! Html::script('/vendor/hegyd/ecommerce/dependencies/select2/dist/js/select2.full.min.js') !!}
{!! Html::script('/vendor/hegyd/ecommerce/dependencies/select2/dist/js/i18n/fr.js') !!}

{!! Html::script('/vendor/hegyd/ecommerce/js/datatable/datatable.js') !!}
@endpush


@if ( $attribute->values()->count() > 0  )
    <ol class="dd-list">

        @foreach ($attribute->values()->orderBy('position')->get() as $value)

            <li class="dd-item" id="value_{!! $value->id !!}" data-id="{!! $value->id !!}">
                <div class="dd-handle">

                    <span>
                        {!! $value->value !!}
                    </span>

                    <div class="dd-nodrag pull-right">

                        <a title="@lang('eav.buttons.edit')"
                           class="{!! trans('class.bo.btn.action') !!} jsEditValue"
                           data-href="{!! route('admin.eav.edit', $value->id) !!}"
                        ><span><i class="fas fa-edit"></i></span></a>

                        @if($value->canDelete())
                            <a title="@lang('eav.buttons.delete')"
                               class="{!! trans('class.bo.btn.action') !!} jsDeleteValue"
                               data-href="{!! route('admin.eav.destroy', $value->id) !!}"
                            ><span><i class="fas fa-times"></i></span></a>
                        @endif

                    </div>

                </div>

            </li>

        @endforeach

    </ol>

@else

    <div>
        @lang('eav.messages.no_values')
    </div>

@endif

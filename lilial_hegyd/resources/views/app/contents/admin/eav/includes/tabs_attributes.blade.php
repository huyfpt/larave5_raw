<div class="tabs-container">
    <div class="panel-options">
        <ul class="nav nav-tabs">
            @php
                $firstAttributeTab = true;
            @endphp
            @foreach($attributes as $attribute)
                <li class="<?= ($firstAttributeTab) ? 'active' : '' ?>">
                    <a data-toggle="tab" href="#attribute_{!! $attribute->id !!}"
                       aria-expanded="<?= ($firstAttributeTab) ? '1' : '' ?>">
                        {!! $attribute->transAttribute('label') !!}
                    </a>
                </li>
                @php
                    $firstAttributeTab = false;
                @endphp
            @endforeach
        </ul>
    </div>
</div>
<div class="panel-body">
    <div class="tab-content">

        @php
            $firstAttributeTab = true;
        @endphp
        @foreach($attributes as $attribute)

            <div id="attribute_{!! $attribute->id !!}"
                 class="tab-pane <?= ($firstAttributeTab) ? 'active' : '' ?>">

                <div class="actions pull-right">
                    <a title="@lang('eav.buttons.add')" class="btn btn-primary jsAddValue"
                       data-attribute-id="{!! $attribute->id !!}"
                       data-href="{!! route('admin.eav.create') !!}?attribute_id={!! $attribute->id !!}">
                        @lang('eav.buttons.add')
                    </a>
                </div>

                <p>@lang('eav.title.values_tab', ['name' => $attribute->transAttribute('label')] )</p>

                @include(
                    'app.contents.admin.eav.includes.values_container',
                    ['attribute' => $attribute, ]
                )

            </div>

            @php
                $firstAttributeTab = false;
            @endphp

        @endforeach

    </div>
</div>

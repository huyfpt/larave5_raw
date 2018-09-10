<div class="tabs-container">
    <div class="panel-options">
        <ul class="nav nav-tabs">
            @php
                $firstEntityTab = true;
            @endphp
            @foreach($entityKeys as $key => $entityKey)
                <li class="<?= ($firstEntityTab) ? 'active' : '' ?>">
                    <a data-toggle="tab" href="#entity_{!! $key !!}"
                       aria-expanded="<?= ($firstEntityTab) ? '1' : '' ?>">
                        {!! trans($entityKey.'.label') !!}
                    </a>
                </li>
                @php
                    $firstEntityTab = false;
                @endphp
            @endforeach
        </ul>
    </div>
</div>

<div class="panel-body">
    <div class="tab-content">

        @php
            $firstEntityTab = true;
        @endphp
        @foreach($entityKeys as $key => $entityKey)
            <div id="entity_{!! $key !!}"
                 class="tab-pane <?= ($firstEntityTab) ? 'active' : '' ?>">
                @include(
                    'app.contents.admin.eav.includes.tabs_attributes',
                    ['attributes' => $attributes[$entityKey]]
                )
            </div>
            @php
                $firstEntityTab = false;
            @endphp
        @endforeach

    </div>
</div>

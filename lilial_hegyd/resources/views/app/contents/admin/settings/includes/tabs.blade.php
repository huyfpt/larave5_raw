<div class="tabs-container">
    <div class="panel-options">
        <ul class="nav nav-tabs">
            @foreach($categories as $key => $category)
                <li class="<?= ($key == 0) ? 'active' : '' ?>">
                    <a data-toggle="tab" href="#tab-{!! $category->id !!}"
                       aria-expanded="<?= ($key == 0) ? '1' : '' ?>">{!! $category->name !!}</a>
                </li>
            @endforeach
        </ul>
    </div>

</div>
<div class="panel-body">
    <div class="tab-content">
        @foreach($categories as $key => $category)
            <div id="tab-{!! $category->id !!}"
                 class="tab-pane <?= ($key == 0) ? 'active' : '' ?>">
                @if(isset($settings[$category->id]))
                    @foreach($settings[$category->id] as $setting)
                        @if($setting->type == \App\Models\Content\Setting::TYPE_IMAGE)
                            @include('app.includes.form.image', [
                                'model'         => $setting,
                                'field'         => 'file_'. $setting->id,
                                'label'         => $setting->name,
                                'preview_src'   => $setting->file ? $setting->file->media : '',
                                'recommended_size'   => $setting->description,
                            ])
                        @elseif($setting->type == \App\Models\Content\Setting::TYPE_COLOR)
                            @include('app.includes.form.color', [
                                'field' => "settings[$setting->id]",
                                'label' => $setting->name,
                                'value' => $setting->value,
                                'description' => $setting->description,
                            ])
                        @else
                            @include('app.contents.admin.settings.includes.field_default')
                        @endif
                    @endforeach
                @endif
            </div>
        @endforeach
    </div>
</div>

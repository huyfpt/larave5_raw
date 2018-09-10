<div class="form-group">
    <label for="{!! $setting->key !!}" class="col-sm-2 control-label">{!! $setting->name !!}</label>
    @if($setting->description)
        <br>
        <span class="recommended">{!! $setting->description !!}</span>
    @endif
    <div class="col-md-10">
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa {!! $setting->icon !!}"></i>
            </span>
            @if($setting->type == \App\Models\Content\Setting::TYPE_TEXTAREA)
                {!! Form::textarea("settings[$setting->id]", $setting->value, [
                    'class' => 'form-control',
                    'placeholder' => $setting->name,
                    'id' => $setting->key,
                    'rows' => '2'
                ]) !!}
            @elseif($setting->type == \App\Models\Content\Setting::TYPE_NUMBER)
                {!! Form::number("settings[$setting->id]", $setting->value, [
                    'class' => 'form-control',
                    'placeholder' => $setting->name,
                    'id' => $setting->key,
                    'min' => 0
                ]) !!}
            @elseif($setting->type == \App\Models\Content\Setting::TYPE_EMAIL)
                {!! Form::email("settings[$setting->id]", $setting->value, [
                    'class' => 'form-control',
                    'placeholder' => $setting->name,
                    'id' => $setting->key
                ]) !!}
            @elseif($setting->type == \App\Models\Content\Setting::TYPE_IMAGE)
                @include('app.includes.form.image', [
                    'model'         => $setting,
                    'field'         => 'file_'. $setting->id,
                    'preview_src'   => $setting->file ? $setting->file->media : ''
                ])
            @else
                {!! Form::text("settings[$setting->id]", $setting->value, [
                    'class' => 'form-control',
                    'placeholder' => $setting->name,
                    'id' => $setting->key
                    ]) !!}
            @endif
        </div>
    </div>
</div>
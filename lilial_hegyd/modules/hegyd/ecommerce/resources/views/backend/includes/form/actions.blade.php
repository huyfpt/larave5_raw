<div class="actions pull-right">
    <input type="hidden" name="_action" id="_action" />
    {{--<a name="cancel-btn" href="{!! URL::previous() !!}" class="btn btn-default bg-navy cancel-btn">--}}
        {{--@lang('app.buttons.cancel')--}}
    {{--</a>--}}
    {{--<a name="reset-btn"  href="{!! URL::current() !!}" class="btn btn-default reset-btn">--}}
        {{--@lang('app.buttons.reset')--}}
    {{--</a>--}}
    <button type="submit" name="save" class="btn btn-primary save-btn">
        @lang('app.buttons.save')
    </button>
    <button type="submit" name="save-and-close" class="btn btn-danger save-and-close-btn">
        @lang('app.buttons.save_and_cancel')
    </button>
    <button type="submit" name="save-and-new" class="btn btn-danger save-and-new-btn">
        @lang('app.buttons.save_and_new')
    </button>
    @if(isset($more_actions))
        @foreach($more_actions as $action)
            @if(!isset($action['only_exists']) || ($action['only_exists'] && $model->exists))
                    <a href="{{ $action['href'] }}"
                       {!! isset($action['target']) ? 'target="' . $action['target'] . '"' : '' !!}
                        class="btn {{ $action['class'] }}">
                    {{$action['text']}}
                </a>
            @endif
        @endforeach
    @endif
</div>

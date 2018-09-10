<div class="actions pull-right">
    <input type="hidden" name="_action" id="_action" />
    <a name="cancel-btn" href="{!! URL::previous() !!}" class="btn btn-default bg-navy cancel-btn">
        @lang('app.buttons.cancel')
    </a>
    <a name="reset-btn"  href="{!! URL::current() !!}" class="btn btn-default reset-btn">
        @lang('app.buttons.reset')
    </a>
    <button type="submit" name="save" class="btn btn-primary save-btn">
        @lang('app.buttons.save')
    </button>
    <button type="submit" name="save-and-close" class="btn btn-danger save-and-close-btn">
        @lang('app.buttons.save_and_cancel')
    </button>
    <button type="submit" name="save-and-new" class="btn btn-warning save-and-new-btn">
        @lang('app.buttons.save_and_new')
    </button>
    {{--@if($model->active)
        <button type="submit" name="save-and-force-reset-password-btn" class="btn btn-default btnForcePasswordReset">
            @lang('users.buttons.saveAndForceResetPassword')
        </button>
    @endif--}}
</div>

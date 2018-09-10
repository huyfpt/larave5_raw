@inject('service','App\Services\Common\UserService')

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        &times;
    </button>
    <h4 class="modal-title">{!! $title !!}</h4>
</div>
<div class="modal-body">
    <div class="form-material form-horizontal">
        <div class="form-group col-md-6">
            <label class="col-md-12">@lang('users.fields.civility')</label>
            <div class="col-md-12">
                {!! $service->civilityText($model->civility) !!}
            </div>
        </div>
        <div class="form-group col-md-6">
            <label class="col-md-12">@lang('users.fields.firstname')</label>
            <div class="col-md-12">
                {!! $model->firstname !!}
            </div>
        </div>
        <div class="form-group col-md-6">
            <label class="col-md-12">@lang('users.fields.lastname')</label>
            <div class="col-md-12">
                {!! $model->lastname !!}
            </div>
        </div>
        <div class="form-group col-md-6">
            <label class="col-md-12">@lang('users.fields.email')</label>
            <div class="col-md-12">
                {!! $model->email ?: trans('app.no_communicated') !!}
            </div>
        </div>
        <div class="form-group col-md-6">
            <label class="col-md-12">@lang('users.fields.phone')</label>
            <div class="col-md-12">
                {!! $model->phone ?: trans('app.no_communicated') !!}
            </div>
        </div>
        <div class="clearfix"></div>

        @php
            $address = $model->address;
        @endphp
        @if($address)
            <hr>
            <div class="form-group col-md-6">
                <label class="col-md-12">@lang('addresses.fields.address')</label>
                <div class="col-md-12">
                    {!! $address && $address->address ? $address->address : trans('app.no_communicated') !!}
                </div>
            </div>
            <div class="form-group col-md-6">
                <label class="col-md-12">@lang('addresses.fields.additional_1')</label>
                <div class="col-md-12">
                    {!! $address && $address->additional_1 ? $address->additional_1 : trans('app.no_communicated') !!}
                </div>
            </div>
            <div class="form-group col-md-6">
                <label class="col-md-12">@lang('addresses.fields.zip')</label>
                <div class="col-md-12">
                    {!! $address && $address->zip ? $address->zip : trans('app.no_communicated') !!}
                </div>
            </div>
            <div class="form-group col-md-6">
                <label class="col-md-12">@lang('addresses.fields.city')</label>
                <div class="col-md-12">
                    {!! $address && $address->city ? $address->city : trans('app.no_communicated') !!}
                </div>
            </div>
            <div class="form-group col-md-6">
                <label class="col-md-12">@lang('addresses.fields.country')</label>
                <div class="col-md-12">
                    {!! $address && $address->country ? $address->country->title_fr : trans('app.no_communicated') !!}
                </div>
            </div>
        @endif
        <div class="clearfix"></div>
    </div>
</div>
<div class="modal-footer">
    <div class="col-md-offset-5 col-md-7">
        <button type="button" class="btn btn-default"
                data-dismiss="modal">@lang('app.buttons.close')</button>
    </div>
</div>
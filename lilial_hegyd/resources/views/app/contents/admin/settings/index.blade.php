@extends('layouts.app')

@section('title')
    {!! $title !!}
@endsection
@section('content')

    <div class="row">
        <div class="white-box">
            <div class="row">
                @if (session('message'))
                    <div class="alert alert-success">
                        {!!  (session('message')) !!}
                    </div>
                @endif
                {!! Form::open([
                            'method'    => 'put',
                            'route'     => 'admin.settings.update',
                            'class'     => 'form-horizontal',
                            'id'        => 'settings_form' ,
                            'role'      => 'form',
                            'files'     => true
                ]) !!}
                <div class="col-lg-12">
                    <div class="panel blank-panel">
                        @include('app.contents.admin.settings.includes.tabs')
                    </div>
                </div>
                <hr/>
                <div class="col-md-12">
                    <div class="actions pull-right">
                        @if(Entrust::can('admin.settings.edit'))
                            <button id="settingFormSubmit" type="submit"
                                    class="btn btn-primary  pull-right">@lang('settings.button.save')</button>
                        @endif
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#settingFormSubmit').on('click', function () {
                $('#settings_form').submit();
            })
        });
    </script>
@endsection

@push('scripts')
{{--{!! Html::script('/backend/js/init_graph_dash.js') !!}--}}


@endpush
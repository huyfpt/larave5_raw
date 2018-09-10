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

                <div class="col-lg-12">
                    <div class="panel blank-panel">
                        @include('app.contents.admin.eav.includes.tabs_entities')
                    </div>
                </div>

                <hr/>

            </div>
        </div>
    </div>

    <div id="modal" class="modal fade" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            </div>
        </div>
    </div>

@endsection

@push('stylesheets')

    {!! Html::style('/vendor/bower/nestable-2/jquery.nestable.css') !!}

    {{-- Have to force popup CSS vendors that are not loaded in AJAX --}}
    {!! Html::style('/vendor/bower/select2/dist/css/select2.min.css') !!}
    {!! Html::style('/vendor/bower/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') !!}

@endpush

@push('scripts')

    {!! Html::script('/vendor/bower/nestable-2/jquery.nestable.js') !!}

    {{-- Have to force popup CSS vendors that are not loaded in AJAX --}}
    {!! Html::script('/vendor/bower/select2/dist/js/select2.full.min.js') !!}
    {!! Html::script('/vendor/bower/select2/dist/js/i18n/fr.js') !!}
    {!! Html::script('/vendor/bower/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') !!}
    {!! Html::script('/app/js/colorpicker.js') !!}

    {{-- Load custom JS --}}
    {!! Html::script('/app/js/attributes/index.js') !!}

    <script>

        $(document).ready(function () {
            Attributes.init();
        });

    </script>

@endpush


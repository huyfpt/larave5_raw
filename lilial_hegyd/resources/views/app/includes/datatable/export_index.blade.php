@extends('layouts.app')

@section('title')
{!! $title !!}
@endsection

@section('content')
<div class="col-md-12">
    <div class="portlet light">
        <div class="portlet-title">
            <div class="caption">
                <i class="fas fa-user font-green-haze"></i>
                <span class="caption-subject font-green-haze bold uppercase">{!! $title !!}</span>
                <span class="caption-helper"></span>
            </div>
            <div class="actions">
                <a href="{{ route( $config['prefixes']['route'] . 'create') }}" class="btn green-haze btn-circle">
                    <i class="fas fa-plus"></i>
                    <span class="hidden-480">@Lang($config['prefixes']['lang'] . 'new')</span>
                </a>
                <button id="export-excel" data-href="{{ route( $config['prefixes']['route'] . 'export') }}" class="btn red-haze btn-circle export-rows">
                    <i class="fas fa-download"></i>
                    <span class="hidden-480">@Lang('app.export_excel')</span>
                </button>
            </div>
        </div>
        <div class="portlet-body">
            @include('includes.datatable.datatable')
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript" src="{{ asset ('app/js/datatable/default.js') }}"></script>
<script type="text/javascript" src="{{ asset ('app/js/export.js') }}"></script>
@endpush

@extends(config('hegyd-permissions.main_layout'))

@section('title')
    Droits & Rôles
@endsection

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                @if (session('message'))
                    <div class="alert alert-success">
                        {!!  (session('message')) !!}
                    </div>
                @endif
            </div>
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>@lang('hegyd-permissions::permissions.title.permissions')</h5>
                    </div>
                    <div class="ibox-content">
                        {!! Form::open(['route' => config('hegyd-permissions.routes.update'), 'method' => 'PUT']) !!}
                        <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                @foreach($rootCategories as $k => $root)
                                    <li class="<?= $k == 0 ? 'active' : '' ?>">
                                        <a data-toggle="tab" href="#tab-<?= $k ?>">{!! $root->name !!}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="tab-content">
                            @foreach($rootCategories as $k => $root)
                                <div id="tab-<?= $k ?>" class="tab-pane <?= $k == 0 ? 'active' : '' ?> ">
                                    @include('hegyd-permissions::tab')
                                </div>
                            @endforeach
                        </div>
                        <hr>
                        @if($perm_edit)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-right">
                                        {!! Form::submit(trans('hegyd-permissions::permissions.button.save'), ['class' => 'btn btn-primary']) !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
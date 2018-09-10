<div class="row bg-title">
    <div class="col-md-8">
        <h4 class="page-title">{{ isset($title) ? $title : '' }}</h4>
            <div class="">
                @if (isset($breadcrumb))
                    {!! $breadcrumb !!}
                @endif
	    </div>
    </div>
    <div class="col-md-4">@yield('header_actions')</div>
</div>
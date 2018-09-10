<style type="text/css">

	#page-wrapper,
	html {
		background: {!! $colorBodyBackground !!};
	}
	
	.label-info,
	.sidebar {
		background: {!! $colorSidebarBackground !!};
		color: {!! $colorSidebarLinks !!};
	}
	.user-profile .user-pro-body .u-dropdown,
	#side-menu li a,
	.nav>li {
		color: {!! $colorSidebarLinks !!};
	}
	.navbar-header {
		background: {!! $colorHeaderBackground !!};
	}

	.btn-info, .btn-info.disabled {
	    background: {!! $colorMain !!};
	    border: 1px solid {!! $colorMain !!};
	}
	a,
	.btn-info.btn-outline {
    	color: {!! $colorMain !!};
	}

	.pagination > .active > a, 
	.pagination > .active > span, 
	.pagination > .active > a:hover, 
	.pagination > .active > span:hover, 
	.pagination > .active > a:focus, 
	.pagination > .active > span:focus,

	.nav-tabs > li > a.active,
	.btn-info.btn-outline:hover, .btn-info.btn-outline:focus, .btn-info.btn-outline.focus {
		background: {!! $colorMain !!};
		border-color: {!! $colorMain !!};
	}
	
	.navbar-top-links > li > a,
	.navbar-top-links > li {
		color: {!! $colorHeaderLinks !!};
	}

	.wizard > .steps .current a, 
	.wizard > .steps .current a:hover, 
	.wizard > .steps .current a:active,

	.text-info {
		color: {!! $colorMain !!}
	}
    .bg-info {
        background-color: {!! $colorMain !!} !important;
    }

    .progress-bar,

    .label-primary,

	.btn-primary:hover,
	.btn-primary.disabled:hover,
	.btn-primary:focus,
	.btn-primary.disabled:focus,
	.btn-primary.focus,
	.btn-primary.disabled.focus,


	.btn-primary, 
	.btn-primary.disabled,

	.btn-info.active.focus, 
	.btn-info.active:focus, 
	.btn-info.active:hover, 
	.btn-info.focus:active, 
	.btn-info:active:focus, 
	.btn-info:active:hover, 
	.open > .dropdown-toggle.btn-info.focus, 
	.open > .dropdown-toggle.btn-info:focus, 
	.open > .dropdown-toggle.btn-info:hover, 
	.btn-info.focus, .btn-info:focus,


	.btn-info:hover, 
	.btn-info.disabled:hover, 
	.btn-info:focus, 
	.btn-info.disabled:focus, 
	.btn-info.focus, 
	.btn-info.disabled.focus {
	    background: {!! $colorMain !!};
	    border: 1px solid {!! $colorMain !!};
	}

	.wizard > .steps .current span.number, 
	.wizard > .steps .current span.number:hover, 
	.wizard > .steps .current span.number:active {
		border-color: {!! $colorMain !!};
		color: {!! $colorMain !!};
	}

    /* Force visuals if available */
    .login-register {
        background-image: url({!! $visualLoginBackground !!}) !important;
    }

    .customtab li.active a,
    .customtab li.active a:hover,
    .customtab li.active a:focus {
        border-bottom: 2px solid {!! $colorMain !!};
        color: {!! $colorMain !!};
    }

    .ope-1 {
        background: #aacb00;
    }
    .ope-2 {
        background: #ca8b88;
    }
    .ope-3 {
        background: #62a553;
    }
    .ope-4 {
        background: #787878;
    }
    .ope-5 {
        background: {!! $colorMain !!};
    }
</style>

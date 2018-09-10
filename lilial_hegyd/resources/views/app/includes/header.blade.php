@php
    $user = auth()->user();
@endphp
<nav class="navbar navbar-default navbar-static-top m-b-0">
    <div class="navbar-header"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
        <div class="top-left-part">
            <a class="logo" href="/">
                <b><!--This is dark logo icon--></b>
                <span class="hidden-xs"><!--This is dark logo text--></span>
            </a>
        </div>
        <ul class="nav navbar-top-links navbar-right pull-right">
            <li class="dropdown notifications-dropdown">
                @include('app.includes.notifications.list')
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                    <img src="{{ $user->media()}}" alt="user-img" width="36" class="img-circle">
                    <b class="hidden-xs">{{$user->fullname()}}
                    </b>
                </a>
                <ul class="dropdown-menu dropdown-user animated flipInY">
                    @if(Entrust::can('extranet.profile.show'))
                    <li><a href="{!! route('extranet.users.my_profile') !!}"><i class="ti-user"></i> Mon profil</a></li>
                    @endif
                    <li role="separator" class="divider"></li>
                    <li>
                        <a href="{!! session('impersonateId') === null
                                   ? route('auth.logout')
                                   : route('admin.users.logoutas') !!}">
                            <i class="fas fa-power-off"></i>
                            <span class="nav-label">
                                {!! session('impersonateId') === null
                                ? trans('auth.buttons.logout')
                                : trans('auth.buttons.logout_impersonate_to') !!}
                            </span>
                        </a>
                    </li>
                </ul>

            </li>
        </ul>
    </div>
</nav>
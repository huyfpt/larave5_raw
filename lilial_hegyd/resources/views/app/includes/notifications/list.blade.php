<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" title="@lang('notifications.buttons.my')" >
    <i class="fas fa-bell fa-2x"></i>
    @if(isset($user_notifications_count) && $user_notifications_count)
        <span class="badge {{isset($hundred_class) && $hundred_class ? 'hundred_class' : ''}}">
            {{ $user_notifications_count }}
        </span>
    @endif
</a>
<ul class="dropdown-menu dropdown-alerts">
    @if(isset($user_notifications) && $user_notifications->count())
        @foreach($user_notifications as $notification)
            @include('app.includes.notifications.item')
        @endforeach
        <li class="divider"></li>
    @else
        <div class="alert alert-info text-center">
            @lang('notifications.messages.no_unseen_notifications')
        </div>
    @endif
    <li>
        <div class="text-center link-block">
            <a href="{{ route('extranet.notifications.index') }}">
                <strong>@lang('notifications.buttons.view-all')</strong>
                <i class="fas fa-angle-right"></i>
            </a>
        </div>
    </li>
</ul>

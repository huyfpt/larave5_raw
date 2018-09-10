@inject('notificationService', 'App\Services\Common\NotificationService')
@if($notifications->count())
    @foreach($notifications as $notification)
        @include('app.contents.extranet.notifications.includes.item')
    @endforeach
@else
    <div class="alert alert-info">@lang('notifications.messages.no_notifications')</div>
@endif
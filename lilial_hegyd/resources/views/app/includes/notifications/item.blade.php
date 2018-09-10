@php
    $data = $notification->data;
@endphp
<li class="notif-item" data-id="{{ $notification->id }}">
    <a href="{{ isset($data['href']) ? $data['href'] : '#'}}">
        <div class="dropdown-messages-box">
            <span class="pull-left notif-icon">
                <i class="fas fa-envelope fa-fw"></i>
            </span>
            <div class="media-body ">
                {{ isset($data['message']) ? $data['message'] : '' }}
                <br>
                <small class="text-muted">{{ $notification->created_at->format('d/m/Y H:i:s') }}</small>
                <small class="pull-right">{{ $notification->created_at->diffForHumans() }}</small>
            </div>
        </div>
    </a>
</li>
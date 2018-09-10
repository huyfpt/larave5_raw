@php
    $data = $notification->data;
@endphp
<div class="feed-element {!! $notification->read_at ? '' : 'unread' !!}"
     data-id="{!! $notification->id !!}">
    <div class="col-md-9">
        <div>
            <strong>
                @if(isset($data['href']) && $data['href'] != '#')
                    <a href="{!! $data['href'] !!}">
                @endif
                <span class="title">
                    {!! isset($data['message']) ? $data['message'] : '' !!}
                </span>
                @if(isset($data['href']) && $data['href'] != '#')
                    </a>
                @endif
            </strong>
        </div>
        <div>
            <small class="text-muted">{!! $notification->created_at->format('d/m/Y H:i:s') !!}</small>
        </div>
    </div>
    <div class="col-md-1 pull-right text-right">
        <div>
            <span class="mark-as-unread"
                  style="{!! $notification->read_at ? '' : 'display:none' !!}"
                  data-toggle="tooltip"
                  data-placement="left"
                  title="{!! trans('notifications.buttons.unread') !!}">
                <i class="fas fa-eye-slash"></i>
            </span>
            <span class="mark-as-read"
                  style="{!! $notification->read_at ? 'display:none' : '' !!}"
                  data-toggle="tooltip"
                  data-placement="left"
                  title="{!! trans('notifications.buttons.read') !!}">
                <i class="fas fa-eye"></i>
            </span>
            <span class="delete"
                  data-toggle="tooltip"
                  data-placement="left"
                  title="{!! trans('app.delete') !!}">
                <i class="fas fa-trash"></i>
            </span>
        </div>
        <div>
            <small class="text-navy">
                {!! $notification->created_at->diffForHumans() !!}
            </small>
        </div>
    </div>
</div>
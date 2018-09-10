
@inject('settingService', 'App\Services\Content\SettingService')

<footer class="footer">

    @if($social_networks = $settingService->getSettingSocialNetwork())
        <div class="pull-left">
            @foreach($social_networks as $social_network)
                <a href="{{ $social_network->value }}" target="_blank"><i class="fa {!! $social_network->icon !!}-square fa-2x"></i></a>
            @endforeach
        </div>
    @endif


    <span class="pull-right">@lang('app.labels.copyright')</span>


</footer>

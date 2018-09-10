@php
    $settingService = app(config('hegyd-ecommerce.services.setting'));

    $visual = $settingService->getSettingByKey('visual.logo')->media();
    $company = $settingService->get('company.name');
    $capital = $settingService->get('company.capital');
    $address = $settingService->get('company.address');
    $additional = $settingService->get('company.additional');
    $zip = $settingService->get('company.zip');
    $city = $settingService->get('company.city');
    $country = $settingService->get('company.country');
    $fax = $settingService->get('company.fax');
    $phone = $settingService->get('company.phone');
    $siret = $settingService->get('company.siret');
    $ape = $settingService->get('company.ape');
    $url = $settingService->get('company.url');
    $email = $settingService->get('company.email');
@endphp

<div id="footer">
    <div>
        @if($capital)
        {{ $company }} au capital de {{ app_number_format($capital) }}&nbsp;€
        - @endif
            {{ $address }} - {{ $additional }} - {{ $zip }} {{ $city }} {{ $country }}
        <br>
        @if($fax) Fax : {{ $fax }} –@endif @if($phone)Téléphone : {{ $phone }} –@endif @if($siret)SIRET : {{ $siret }} –@endif @if($ape)APE : {{ $ape }}@endif
        <br>
        @if($url)
            Site : {{ $url }} –
        @endif
        Email : {{ $email }}
    </div>
    <div class="pull-right"><span class="page"></span></div>
</div>

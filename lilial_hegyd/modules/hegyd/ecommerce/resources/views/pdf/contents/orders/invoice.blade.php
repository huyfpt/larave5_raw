@extends('hegyd-ecommerce::layouts.pdf')
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

@section('style')

    .detailTable .title th {
    background: #eaebed;
    padding:15px 0;
    border: 1px solid #b8b8b9;
    font-size: 11px;
    }
    .detailTable td {
    border: 1px solid #b8b8b9;
    padding:10px;
    vertical-align: middle;
    }
    .detailTable {
    margin: 25px 0 0 0;
    min-height: 300px;
    }
    div.title {
    font-size: 30px;
    font-weight: 200;
    border-bottom: 4px solid #191B1E;
    padding: 15px 0 15px 0;

    }

    .infoTitle {
    float: right;
    font-size: 13px;
    text-align: right;
    text-transform: uppercase;
    margin: 10px 0 0 0;
    }
@endsection
@section('header')
    <table style='width:100%'>
        <tr>
            <td style="width: 45%; text-align: left;">
                <img src="{{ $visual }}" alt="{{ $company}}"
                     width="200"/>
            </td>
            <td style="width: 10%"></td>
            <td style="width: 45%; text-align: right; font-size: 22px">
                <div style="font-size: 20px;font-weight: 200; text-transform: uppercase">
                    @lang('hegyd-ecommerce::orders.labels.invoice')
                </div>
            </td>
        </tr>
    </table>
@endsection
@section('content')
    <table style='width:100%'>
        <tr>
            <td style="width: 45%; text-align: left;">
                <div style="font-weight: bold; text-transform: uppercase">@lang('hegyd-ecommerce::orders.labels.transmitter')</div>
                <div style="background: #eaebed; padding: 10px 20px; margin-top: 10px; height: 120px;">
                    <div style="font-size: 20px; margin-bottom: 10px">
                        <b>{{ $company }}</b>
                    </div>
                    {{ $address }} <br>
                    {{ $additional }} <br><br>
                    {{ $zip }} {{ $city }} <br>
                    {{ $country }}
                </div>
            </td>
            <td style="width: 10%"></td>
            <td style="width: 45%; text-align: left;">
                <div style="font-weight: bold; text-transform: uppercase">@lang('hegyd-ecommerce::orders.labels.receiver')</div>
                <div style="border: 1px solid; padding: 10px 20px; margin-top: 10px; height: 120px;">
                    @if($order->invoice_company)
                        <b>{{ $order->invoice_company }}</b><br>
                    @endif
                    @if($order->invoice_lastname)
                        <b>{{ $order->invoice_lastname }} {{ $order->invoice_firstname }}</b>
                        <br>
                    @endif
                    @if($order->invoice_address)
                        {{ $order->invoice_address }} <br>
                    @endif
                    @if($order->invoice_additional_1)
                        {{ $order->invoice_additional_1 }} <br>
                    @endif
                    @if($order->invoice_additional_2)
                        {{ $order->invoice_additional_2 }} <br>
                    @endif
                    <br>
                    @if($order->invoice_zip && $order->invoice_city)
                        {{ $order->invoice_zip }} {{ $order->invoice_city }}
                        <br>
                    @endif
                    @if($order->invoice_country)
                        {{ $order->invoice_country }}
                    @endif
                </div>
            </td>
        </tr>
    </table>

    <br>
    <div class="title">
        <div class="infoTitle">
            <div>@lang('hegyd-ecommerce::orders.fields.reference') : <strong>{{ $order->reference }}</strong></div>
            <div>@lang('hegyd-ecommerce::orders.fields.date') :
                <strong>{{ $order->created_at->format('d/m/Y') }}</strong></div>
        </div>
        @lang('hegyd-ecommerce::orders.labels.invoice_euro')
    </div>

    <table style="width: 100%; border-collapse: collapse;" class="detailTable">
        <thead>
        <tr class="title">
            <th style="width: 10%">@lang('hegyd-ecommerce::orders.fields.product_reference')</th>
            <th style="width: 55%">@lang('hegyd-ecommerce::orders.fields.product_name')</th>
            <th style="width: 10%">@lang('hegyd-ecommerce::orders.fields.unit_price_ht')</th>
            <th style="width: 10%">@lang('hegyd-ecommerce::orders.fields.unit_price_ttc')</th>
            <th style="width: 10%">@lang('hegyd-ecommerce::orders.fields.quantity')</th>
            <th style="width: 15%">@lang('hegyd-ecommerce::orders.fields.total_line_ht')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->lines as $line)
            <tr>
                <td class="text-center">{{ $line->product_reference }}</td>
                <td>{{ $line->product_name }}</td>
                <td class="text-center">{{ app_number_format($line->unit_price_ht) }}&nbsp;€</td>
                <td class="text-center">{{ app_number_format($line->unit_price_ttc) }}&nbsp;€</td>
                <td class="text-center">{{ $line->quantity }}</td>
                <td class="text-center">{{ app_number_format($line->total_ht) }}&nbsp;€</td>
            </tr>
        @endforeach
        </tbody>

        <tr style="height: 20px">
            <td colspan="3"
                rowspan="4"
                style="text-align: center; font-size: 9; font-weight: bold;"
                valign="middle">
                @if($paid_at = $order->paid_at)
                    @lang('hegyd-ecommerce::orders.messages.paid_at', [
                    'date' => $paid_at->format('d/m/Y H:i:s'),
                    'provider' => app(\Hegyd\eCommerce\Services\eCommerce\OrderService::class)->paymentMeansText($order->payment_means)
                    ])
                @endif
            </td>
            <td style="padding-left: 10px" colspan="2"><b>@lang('hegyd-ecommerce::orders.fields.delivery_price')</b></td>
            <td class="text-center" style="padding: 5px; padding-right: 10px;">
                {{ app_number_format($order->delivery_price) }}&nbsp;€
            </td>
        </tr>
        <tr>
            <td style="padding-left:10px;"
                colspan="2"><b>@lang('hegyd-ecommerce::orders.fields.total_ht')</b>
            </td>
            <td class="text-center"
                style="padding: 5px; padding-right: 10px ;">
                {{ app_number_format($order->total_ht) }}&nbsp;€
            </td>
        </tr>
        <tr style="height: 20px">
            <td style="padding-left: 10px" colspan="2"><b>@lang('hegyd-ecommerce::orders.fields.total_vat')</b></td>
            <td class="text-center" style="padding: 5px; padding-right: 10px;">
                {{ app_number_format($order->total_vat) }}&nbsp;€
            </td>
        </tr>
        <tr style="height: 20px">
            <td style="padding-left:10px; font-weight: bold; background-color: lightgray;"
                colspan="2"><b>@lang('hegyd-ecommerce::orders.fields.total_ttc')</b>
            </td>
            <td style="padding: 5px; padding-right: 10px; background-color: lightgray; font-weight: bold;" class="text-center">
                {{ app_number_format($order->total_ttc) }}&nbsp;€
            </td>
        </tr>
@endsection
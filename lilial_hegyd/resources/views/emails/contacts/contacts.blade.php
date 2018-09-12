@extends('emails.layouts.email')

@section('welcome')
    {{ isset($user) ? trans('emails.global.welcome', ['fullname' => $user->fullname()]) : '' }}
@endsection

@section('subject')
    {{ isset($title) ? $title : '' }}
@endsection

@section('message')
    
    <table class="inner-body" align="left" cellpadding="0" cellspacing="0">
        <!-- Body content -->

        @foreach ($body as $label=>$item)
        <tr>
            <td class="content-cell" style="width: 100px;">
                <label>{{ $label }}</label>
            </td>
            <td class="content-cell">
                <label for="">{{$item}}</label>
            </td>
        </tr>
        @endforeach
        
    </table>
@endsection

@section('message2')

@endsection
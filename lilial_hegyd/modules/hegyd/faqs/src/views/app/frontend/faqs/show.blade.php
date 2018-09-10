@extends(config('hegyd-faqs.main_layout.frontend'))

@section('title')
    <title>{{$title}}</title>
@endsection

@section('css')
@endsection

@section('content')
<section class="main">
    @include('hegyd-faqs::app.frontend.faqs.includes.faq-show-slider')

    @include('hegyd-faqs::app.frontend.faqs.includes.faq-detail')
  </section>
@endsection

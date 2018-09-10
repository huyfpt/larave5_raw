
@extends(config('hegyd-faqs.main_layout.frontend'))
@section('title')
  <title>Lilial French - FAQ</title>
@endsection

@section('css')

<style>
#cover-spin {
  position:fixed;
  width:100%;
  left:0;right:0;top:0;bottom:0;
  background-color: rgba(255,255,255,0.7);
  z-index:9999;
  display:none;
}
.inactiveLink {
   pointer-events: none;
   cursor: default;
}

@-webkit-keyframes spin {
  from {-webkit-transform:rotate(0deg);}
  to {-webkit-transform:rotate(360deg);}
}

@keyframes spin {
  from {transform:rotate(0deg);}
  to {transform:rotate(360deg);}
}

#cover-spin::after {
  content:'';
  display:block;
  position:absolute;
  left:48%;top:40%;
  width:40px;height:40px;
  border-style:solid;
  border-color:#68b429;
  border-top-color:transparent;
  border-width: 4px;
  border-radius:50%;
  -webkit-animation: spin .8s linear infinite;
  animation: spin .8s linear infinite;
}
#faqs_btn_group {
	padding-bottom: 60px;
  padding-left: 60px;
}
#faqs_btn_group .notActive{
  color: #3276b1;
  background-color: #fff;
}

</style>
@endsection

@section('content')
  <section class="main">
    @include('hegyd-faqs::app.frontend.faqs.includes.faq-slider')

    @include('hegyd-faqs::app.frontend.faqs.includes.faq-content')
  </section>
@endsection

@section('js')

@endsection
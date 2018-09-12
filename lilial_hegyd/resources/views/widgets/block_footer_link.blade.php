
  <div class="col-md-3 col-sm-6 ft-uro">
    <h3 class="ft-title">urologie</h3>
    <ul class="menu">
      @foreach ($data[0] as $item) 
        <li><a href="{{ url('/produits/category/'. $item['slug']) }}">{{ $item['name'] }}</a></li>
      @endforeach

        <li><a href="{{ url('faqs/category/soin-de-la-continence-n1') }}">FAQ</a></li>
    </ul>
  </div>

  <!-- END : COL UROLOGIE-->
  <div class="col-md-3 col-sm-6 ft-cica">
    <h3 class="ft-title">CICATRISATION</h3>
    <ul class="menu">
      @foreach ($data[1] as $item) 
        <li><a href="{{ url('/produits/category/'. $item['slug']) }}">{{ $item['name'] }}</a></li>
      @endforeach
      <li><a href="{{ url('faqs/category/stomatherapie-n2') }}">FAQ</a></li>
    </ul>
  </div>
  <!-- END : COL CICATRISATION-->
  <div class="col-md-2 col-sm-2 col-xs-6 ft-stoma">
    <h3 class="ft-title">STOMATHÉRAPIE</h3>
    <ul class="menu">
      @foreach ($data[2] as $item) 
        <li><a href="{{ url('/produits/category/'. $item['slug']) }}">{{ $item['name'] }}</a></li>
      @endforeach
      <li><a href="{{ url('faqs/category/soin-des-plaies-n3') }}">FAQ</a></li>
    </ul>
  </div>
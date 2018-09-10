<div class="logo-list pad-80">
  <div class="container">
    <div class="logo-slider">

      @foreach ($data as $item)
        <div class="logo-item">
          <img src="{{ asset('front/uploads/logo/'. $item->logo) }}" alt="{{ $item->name }}">
        </div>
      @endforeach

    </div>
  </div>
</div>
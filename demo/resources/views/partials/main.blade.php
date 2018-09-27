<!DOCTYPE html>
<html lang="en">
@include('partials._head')

<body>

  @include('partials._nav')
  
  <div class="container">

    @include('partials._messages')

    @yield('content')

  </div>
  <!-- end of .container -->
  
  @include('partials._footer')
  
  @include('partials._js')
  
 
  
</body>

</html>
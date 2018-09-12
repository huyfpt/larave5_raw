<footer class="footer-wrap pad-80">
      <div class="container">
        <div class="row">

          @widget('BlockFooterLink')

          <!-- END : COL URO-->
          <div class="col-md-3 col-sm-6 ft-lilial">
            <h3 class="ft-title">LILIAL</h3>
            <ul class="menu">
              <li><a href="{{ url('/qui-sommes-nous') }}">Qui sommes-nous ?</a></li>
              <li><a href="{{ url('/pages/mentions-legales') }}">Mentions légales</a></li>
              <li><a href="{{ url('/pages/cgu') }}">CGU</a></li>
              <li><a href="{{ url('/contact') }}">Contact</a></li>
              <li><a href="https://career5.successfactors.eu/career?company=Coloplast&site=VjItbHgvK0pWendjMlNLbjc5RU95WlQvdz09" target="_blank">Recrutement</a></li>
              <li><a href="{{ url('/club') }}">Le Club Lilial</a></li>
            </ul><a href="tel:0800880554" class="ft-hotline"><img src="{{ asset('front/uploads/hotline.jpg') }}"></a>
          </div>
          <!-- END : COL LILIAL-->
          <div class="col-md-1 col-sm-1 col-xs-12 ft-social">
            <ul class="menu">
              <li><a href="{{ $setting->get('social.facebook') }}" target="blank"><i class="fa fa-facebook"></i></a></li>
              <li><a href="{{ $setting->get('social.youtube') }}" target="blank"><i class="fa fa-youtube-play"></i></a></li>
              <li><a href="{{ $setting->get('social.linkedin') }}" target="blank"><i class="fa fa-linkedin"></i></a></li>
              <li><a href="{{ $setting->get('social.instagram') }}" target="blank"><i class="fa fa-instagram"></i></a></li>
            </ul>
          </div>
          <!-- END : COL SOCIAL-->
        </div>
      </div>
    </footer>
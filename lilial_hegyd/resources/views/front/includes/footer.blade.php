<footer class="footer-wrap pad-80">
      <div class="container">
        <div class="row">
          <div class="col-md-3 col-sm-6 ft-uro">
            <h3 class="ft-title">urologie</h3>
            <ul class="menu">
              <li><a href="#">Sondage intermitlend</a></li>
              <li><a href="#">Sondage à demeure</a></li>
              <li><a href="#">Etuis péniens</a></li>
              <li><a href="#">Poches de recueil</a></li>
              <li><a href="#">Accessoires</a></li>
              <li><a href="#">Incontience fécale</a></li>
              <li><a href="#">Soins et hygiène</a></li>
            </ul>
            <h4 class="ft-title ft-faq"><a href="#">faq</a></h4>
          </div>
          <!-- END : COL UROLOGIE-->
          <div class="col-md-3 col-sm-6 ft-cica">
            <h3 class="ft-title">CICATRISATION</h3>
            <ul class="menu">
              <li><a href="#">Pansement</a></li>
              <li><a href="#">Adhésifs médicaux</a></li>
              <li><a href="#">Set de pansements</a></li>
              <li><a href="#">Gel / Crème / Sérum</a></li>
              <li><a href="#">FAQ</a></li>
            </ul>
          </div>
          <!-- END : COL CICATRISATION-->
          <div class="col-md-2 col-sm-2 col-xs-6 ft-stoma">
            <h3 class="ft-title">STOMATHÉRAPIE</h3>
            <ul class="menu">
              <li><a href="#">Stomie urinaire</a></li>
              <li><a href="#">Stomie digestive</a></li>
              <li><a href="#">Accessoires</a></li>
              <li><a href="#">Irrigation colique</a></li>
              <li><a href="#">Soins et hygiène</a></li>
              <li><a href="#">FAQ</a></li>
            </ul>
          </div>
          <!-- END : COL URO-->
          <div class="col-md-3 col-sm-6 ft-lilial">
            <h3 class="ft-title">LILIAL</h3>
            <ul class="menu">
              <li><a href="{{ url('/about/qui-sommes-nous') }}">Qui sommes-nous ?</a></li>
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
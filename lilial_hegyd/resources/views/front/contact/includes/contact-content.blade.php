<div class="blk-main-content">
  <div class="home-about blk-page-desc contact-desc">
    <div class="container">
      <h2 class="blk-title">Contactez-nous</h2>
      <div class="about-txt text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ornare vitae nunc non iaculis. Nam dictum vitae magna at imperdiet. Cras tincidunt purus in nunc laoreet auctor. Curabitur ac commodo sem, quis tempus sem. Integer ligula dolor, luctus et bibendum eu, iaculis eu dolor. Aliquam auctor purus ipsum, quis consectetur est tincidunt at. Proin dignissim commodo arcu vitae consectetur.</div>
    </div>
  </div>
  <!-- END: DESC-->
  <div class="contact-form">
    <div class="container">
      <form>
        <div class="form-group row">
          <div class="col-md-6 col-sm-12 col-form">
            <div class="row">
              <div class="col-md-4 col-sm-12 col-form">
                <label for="sl-vous" class="lb-form">Vous êtes</label>
              </div>
              <div class="col-md-8 col-sm-12 col-form">
                <select id="sl-vous" class="ipt ipt-normal">
                  <option>Particulier</option>
                  <option>Particulier 1</option>
                  <option>Particulier 2</option>
                </select>
              </div>
            </div>
          </div>
          <!-- END -->
          <div class="col-md-6 col-sm-12 col-form"></div>
          <!-- END -->
        </div>
        <!-- END -->
        <div class="form-group row">
          <div class="col-md-6 col-sm-12 col-form">
            <div class="row">
              <div class="col-md-4 col-sm-12 col-form">
                <label for="nom" class="lb-form">Nom</label>
              </div>
              <div class="col-md-8 col-sm-12 col-form">
                <input type="text" id="nom" class="ipt ipt-normal">
              </div>
            </div>
          </div>
          <!-- END -->
          <div class="col-md-6 col-sm-12 col-form">
            <div class="row">
              <div class="col-md-4 col-sm-12 col-form">
                <label for="code_postal" class="lb-form">Code postal</label>
              </div>
              <div class="col-md-8 col-sm-12 col-form">
                <input type="text" id="code_postal" class="ipt ipt-normal half">
              </div>
            </div>
          </div>
          <!-- END -->
        </div>
        <!-- END -->
        <div class="form-group row">
          <div class="col-md-6 col-sm-12 col-form">
            <div class="row">
              <div class="col-md-4 col-sm-12 col-form">
                <label for="prenom" class="lb-form">Prénom</label>
              </div>
              <div class="col-md-8 col-sm-12 col-form">
                <input type="text" id="prenom" class="ipt ipt-normal">
              </div>
            </div>
          </div>
          <!-- END -->
          <div class="col-md-6 col-sm-12 col-form">
            <div class="row">
              <div class="col-md-4 col-sm-12 col-form">
                <label for="ville" class="lb-form">Ville</label>
              </div>
              <div class="col-md-8 col-sm-12 col-form">
                <input type="text" id="ville" class="ipt ipt-normal">
              </div>
            </div>
          </div>
          <!-- END -->
        </div>
        <!-- END -->
        <div class="form-group row">
          <div class="col-md-6 col-sm-12 col-form">
            <div class="row">
              <div class="col-md-4 col-sm-12 col-form">
                <label for="email" class="lb-form">Email</label>
              </div>
              <div class="col-md-8 col-sm-12 col-form">
                <input type="text" id="email" class="ipt ipt-normal">
              </div>
            </div>
          </div>
          <!-- END -->
          <div class="col-md-6 col-sm-12 col-form">
            <div class="row">
              <div class="col-md-4 col-sm-12 col-form">
                <label for="phone" class="lb-form">Téléphone</label>
              </div>
              <div class="col-md-8 col-sm-12 col-form">
                <input type="text" id="phone" class="ipt ipt-normal">
              </div>
            </div>
          </div>
          <!-- END -->
        </div>
        <!-- END -->
        <div class="form-group">
          <label class="lb-form">J’accepte de revoir des communications email de la part de Lilial</label>
        </div>
        <!-- END  -->
        <div class="form-group row">
          <div class="col-md-2 col-sm-12 col-form">
            <label for="phone" class="lb-form">Votre message</label>
          </div>
          <div class="col-md-10 col-sm-12 col-form">
            <textarea class="ipt txtarea"></textarea>
          </div>
        </div>
        <!-- END -->
        <div class="form-group text-right">
          <div class="capcha-wrap"><img src="{{ asset('front/uploads/captcha.png') }}" alt=""></div>
          <div class="btn-wrap">
            <button class="btn btn-green">Envoyer</button>
          </div>
        </div>
        <!-- END -->
      </form>
    </div>
  </div>
  <!-- END: FORM-->
  @include('front.includes.home-logo')
  <!-- END: HOME LOGO-->
  @include('front.includes.block')
  <!-- END: BLOCK-->
</div>
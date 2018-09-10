<section class="main">
      <div class="blk-slider profile-banner">
        <div class="blk-banner-info">
          <div class="breadcrumb-wrap">
            <div class="container"><a href="#">Accueil</a><span>Mon profil</span></div>
          </div>
          <!-- END : BREADCRUMB-->
          <div class="profile-avatar">
            <div class="container">
              <div class="row">
                <div class="col-xl-3 col-md-4 col-sm-12 ava-left">
                  <figure style="background-image: url({{$actual_link}}/front/uploads/avatar_men.png)" class="ava-img"></figure>
                </div>
                <!-- END : LEFT-->
                <div class="col-xl-9 col-md-8 col-sm-12 ava-right">
                  <h2 class="ava-ttl">Romain Lauro</h2>
                  <div class="email">romain@adressemail.fr</div>
                </div>
                <!-- END : RIGHT-->
              </div>
            </div>
          </div>
          <!-- END : AVATAR-->
        </div>
      </div>
      <!-- END: BANNER-->
      <div class="blk-main-content">
        <div class="profile-wrap">
          <form>
            <div class="profile-info pad-80">
              <div class="container">
                <div class="row">
                  <div class="col-xl-3 col-md-4 col-sm-12 empty">&nbsp;</div>
                  <!-- END : COL-->
                  <div class="col-xl-9 col-md-8 col-sm-12 col-profile">
                    <h2 class="blk-title">Informations personnelles</h2>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3 col-sm-12 col-label">
                          <label for="utilisateur" class="lb-form">Nom utilisateur</label>
                        </div>
                        <!-- END -->
                        <div class="col-md-9 col-sm-12 col-child">
                          <input type="text" id="utilisateur" value="Romain Lauro" class="ipt ipt-normal">
                        </div>
                        <!-- END -->
                      </div>
                    </div>
                    <!-- END -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3 col-sm-12 col-label">
                          <label for="sl-monsieur" class="lb-form">Civilité *</label>
                        </div>
                        <!-- END -->
                        <div class="col-md-9 col-sm-12 col-child">
                          <select id="sl-monsieur" class="ipt ipt-normal half">
                            <option>Monsieur</option>
                            <option>Monsieur 1</option>
                            <option>Monsieur 2</option>
                          </select>
                        </div>
                        <!-- END -->
                      </div>
                    </div>
                    <!-- END -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3 col-sm-12 col-label">
                          <label for="nom" class="lb-form">Nom *</label>
                        </div>
                        <!-- END -->
                        <div class="col-md-9 col-sm-12 col-child">
                          <input type="text" id="nom" value="Lauro" class="ipt ipt-normal">
                        </div>
                        <!-- END -->
                      </div>
                    </div>
                    <!-- END -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3 col-sm-12 col-label">
                          <label for="prenom" class="lb-form">Prénom *</label>
                        </div>
                        <!-- END -->
                        <div class="col-md-9 col-sm-12 col-child">
                          <input type="text" id="prenom" value="Romain" class="ipt ipt-normal">
                        </div>
                        <!-- END -->
                      </div>
                    </div>
                    <!-- END -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3 col-sm-12 col-label">
                          <label for="email" class="lb-form">Email *</label>
                        </div>
                        <!-- END -->
                        <div class="col-md-9 col-sm-12 col-child">
                          <input type="text" id="email" value="romain@adressemail.fr" class="ipt ipt-normal">
                        </div>
                        <!-- END -->
                      </div>
                    </div>
                    <!-- END -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3 col-sm-12 col-label">
                          <label for="phone" class="lb-form">Téléphone</label>
                        </div>
                        <!-- END -->
                        <div class="col-md-9 col-sm-12 col-child">
                          <input type="text" id="phone" value="06 22 22 22 22" class="ipt ipt-normal">
                        </div>
                        <!-- END -->
                      </div>
                    </div>
                    <!-- END -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3 col-sm-12 col-label">
                          <label for="postal" class="lb-form">Code postal</label>
                        </div>
                        <!-- END -->
                        <div class="col-md-9 col-sm-12 col-child">
                          <input type="text" id="postal" value="13006" class="ipt ipt-normal">
                        </div>
                        <!-- END -->
                      </div>
                    </div>
                    <!-- END -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3 col-sm-12 col-label">
                          <label for="postal" class="lb-form">Photo profil</label>
                        </div>
                        <!-- END -->
                        <div class="col-md-9 col-sm-12 col-child">
                          <div class="upload-photo"><img src="{{ asset('front/uploads/avatar_men.png') }}" alt=""><a href="#" class="btn-upload">Parcourir</a></div>
                        </div>
                        <!-- END -->
                      </div>
                    </div>
                    <!-- END -->
                  </div>
                  <!-- END : COL-->
                </div>
              </div>
            </div>
            <!-- END : INFO-->
            <div class="profile-security pad-40">
              <div class="container">
                <div class="row">
                  <div class="col-xl-3 col-md-4 col-sm-12 empty">&nbsp;</div>
                  <!-- END : COL-->
                  <div class="col-xl-9 col-md-8 col-sm-12 col-profile">
                    <h2 class="blk-title">Sécurité</h2>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3 col-sm-12 col-label">
                          <label for="password" class="lb-form">Mot de passe</label>
                        </div>
                        <!-- END -->
                        <div class="col-md-9 col-sm-12 col-child">
                          <input type="text" id="password" value="XXXXXXXXXXX" class="ipt ipt-normal half"><a href="#" class="btn-upload">Générer</a>
                        </div>
                        <!-- END -->
                      </div>
                    </div>
                    <!-- END -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3 col-sm-12 col-label">
                          <label for="confirmation" class="lb-form">Confirmation</label>
                        </div>
                        <!-- END -->
                        <div class="col-md-9 col-sm-12 col-child">
                          <input type="text" id="confirmation" value="XXXXXXXXXXX" class="ipt ipt-normal half">
                        </div>
                        <!-- END -->
                      </div>
                    </div>
                    <!-- END -->
                  </div>
                  <!-- END : COL-->
                </div>
              </div>
            </div>
            <!-- END : SECURITY-->
            <div class="profile-newsletter pad-80">
              <div class="container">
                <div class="row">
                  <div class="col-xl-3 col-md-4 col-sm-12 empty">&nbsp;</div>
                  <!-- END : COL-->
                  <div class="col-xl-9 col-md-8 col-sm-12 col-profile">
                    <h2 class="blk-title">Newsletter</h2>
                    <div class="form-group">
                      <label class="lb-form">S'abonner et recevoir la newsletter par email</label>
                      <div class="grp-radio">
                        <label class="txt on">OUI</label>
                        <div class="wrap">
                          <input type="checkbox" name="get_email" id="getEmail" class="ipt-checkbox">
                        </div>
                        <label class="txt">NON</label>
                      </div>
                    </div>
                    <!-- END -->
                    <div class="form-group">
                      <button class="btn btn-green">Enregister les modifications</button>
                    </div>
                    <!-- END -->
                  </div>
                  <!-- END : COL-->
                </div>
              </div>
            </div>
            <!-- END : NEWSLETTER-->
          </form>
        </div>
        <!-- END: FORM PROFILE-->
        @include('front.includes.home-logo')
        <!-- END: HOME LOGO-->
        @include('front.includes.block')
        <!-- END: BLOCK-->
      </div>
    </section>
    <!-- END : CONTENT-->
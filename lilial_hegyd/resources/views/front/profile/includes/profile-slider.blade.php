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
            <figure style="background-image: url({{ asset($user->media()) }} )" class="ava-img"></figure>
          </div>
          <!-- END : LEFT-->
          <div class="col-xl-9 col-md-8 col-sm-12 ava-right">
            <h2 class="ava-ttl">{{ $user->firstname.' '.$user->lastname }}</h2>
            <div class="email">{{ $user->email }}</div>
          </div>
          <!-- END : RIGHT-->
        </div>
      </div>
    </div>
    <!-- END : AVATAR-->
  </div>
</div>
<!-- END: BANNER-->
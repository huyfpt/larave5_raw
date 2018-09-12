<section class="main">
  <div class="blk-main-content">
    <div class="profile-wrap">
      <form action="{{ url('/profile') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="profile-info pad-80">
          <div class="container">
            <div class="row">
              <div class="col-xl-3 col-md-4 col-sm-12 empty">&nbsp;</div>
              <!-- END : COL-->
              <div class="col-xl-9 col-md-8 col-sm-12 col-profile">
                @if(session()->has('message'))
                  <div class="alert alert-success">{{ session()->get('message') }}</div>
                @endif
                <h2 class="blk-title">Informations personnelles</h2>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-3 col-sm-12 col-label">
                      <label for="utilisateur" class="lb-form">Nom utilisateur</label>
                    </div>
                    <!-- END -->
                    <div class="col-md-9 col-sm-12 col-child">
                      <input type="text" name="username" readonly="" id="utilisateur" value="{{ $user->username }}" class="ipt ipt-normal">
                      {!! Form::errorMsg('username', $errors) !!}
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
                      <select id="sl-monsieur" name="civility" class="ipt ipt-normal half">
                        <option value="1"{{ ($user->civility == 1) ? 'selected' : '' }}>Monsieur</option>
                        <option value="2"{{ ($user->civility == 2) ? 'selected' : '' }}>Madame</option>
                      </select>
                      {!! Form::errorMsg('civility', $errors) !!}
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
                      <input type="text" id="nom" name="firstname" value="{{ $user->firstname }}" class="ipt ipt-normal" {{ $errors->has('firstname') ? 'autofocus' : null }}>
                      {!! Form::errorMsg('firstname', $errors) !!}
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
                      <input type="text" id="prenom" name="lastname" value="{{ $user->lastname }}" class="ipt ipt-normal" {{ $errors->has('lastname') ? 'autofocus' : null }}>
                      {!! Form::errorMsg('lastname', $errors) !!}
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
                      <input type="text" id="email" readonly="" name="email" value="{{ $user->email }}" class="ipt ipt-normal" {{ $errors->has('email') ? 'autofocus' : null }}>
                      {!! Form::errorMsg('email', $errors) !!}
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
                      <input type="text" id="phone" name="phone" value="{{ $userService->convertPhone($user->phone) }}" class="ipt ipt-normal" {{ $errors->has('phone') ? 'autofocus' : null }}>
                      <label for="phone" class="hintText" style="font-size: 11px; line-height: 1.2">Ex: +33 6 70 44 29 63, +33670442963, 06 70 44 29 63, 06-70-44-29-63, 0670442963</label>
                      {!! Form::errorMsg('phone', $errors) !!}
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
                    @php
                        $post_code = $plansService->populatePostCode();
                    @endphp
                    <div class="col-md-9 col-sm-12 col-child profile_zip">
                      <select class="form-control col-xs-12 col-sm-4" id="profile_zip" name="address[zip]" required="">
                          @if(!empty($post_code))
                              @if(!empty($user->address->zip))
                                  <option selected="" value="{{ $user->address->zip }}">{{ $user->address->zip }}</option>
                              @else
                                  <option value="{{ $user->address->zip }}">{{ $user->address->zip }}</option>
                              @endif
                              @foreach($post_code as $item)
                                  <option value="{{$item->zip}}">{{$item->zip}}</option>
                              @endforeach
                          @endif
                      </select>
                      <!-- <input type="text" id="postal" name="address[zip]" value="{{ $user->address->zip }}" class="ipt ipt-normal" {{ $errors->has('address[zip]') ? 'autofocus' : null }}> -->
                      {!! Form::errorMsg('address[zip]', $errors) !!}
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
                      <div class="upload-photo"><img src="{{ asset($user->media()) }}" alt="">
                        <label for="file-upload" class="btn-upload" style="cursor: pointer;" {{ $errors->has('visual') ? 'autofocus' : null }}>
                            Parcourir
                        </label>
                        <input id="file-upload" class="d-none" name="visual" type="file"/>
                      {!! Form::errorMsg('visual', $errors) !!}
                      </div>
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
                      <div class="alert alert-info d-none" id="passKey"></div>
                      <input type="password" name="password" id="password" value="" class="ipt ipt-normal half" {{ $errors->has('password') ? 'autofocus' : null }}><a class="btn-upload generate_password" type="button" style="cursor: pointer;">Générer</a>
                      {!! Form::errorMsg('password', $errors) !!}
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
                      <input type="password" name="password_confirmation" id="confirmation" value="" class="ipt ipt-normal half" {{ $errors->has('password_confirmation') ? 'autofocus' : null }}>
                      {!! Form::errorMsg('password_confirmation', $errors) !!}
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
                      <input type="checkbox" {{ ($user->newsletter == true) ? 'checked' : '' }} name="newsletter" id="getEmail" class="ipt-checkbox">
                    </div>
                    <label class="txt">NON</label>
                  </div>
                </div>
                <!-- END -->
                <div class="form-group">
                  <button type="submit" class="btn btn-green">Enregister les modifications</button>
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
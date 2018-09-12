<div class="blk-main-content">
  <div class="home-about blk-page-desc contact-desc pad-60">

    <div class="container">
      @if(Session::has('message_error'))
      <div class="alert alert-danger" role="alert">
          {{ Session::get('message_error') }}
      </div>
      @elseif (Session::has('message_success'))
      <div class="alert alert-success" role="alert">
          {{ Session::get('message_success') }}
      </div>
      @endif
    </div>

    <div class="container">
      <h2 class="blk-title">Contactez-nous</h2>
      <div class="about-txt text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ornare vitae nunc non iaculis. Nam dictum vitae magna at imperdiet. Cras tincidunt purus in nunc laoreet auctor. Curabitur ac commodo sem, quis tempus sem. Integer ligula dolor, luctus et bibendum eu, iaculis eu dolor. Aliquam auctor purus ipsum, quis consectetur est tincidunt at. Proin dignissim commodo arcu vitae consectetur.</div>
    </div>
  </div>
  <!-- END: DESC-->
  <div class="contact-form">
    <div class="container">


      {!! Form::open(array('url' => '/contact/send', 'class' => 'form-horizontal')) !!}
        <div class="form-group row">
          <div class="col-md-6 col-sm-12 col-form">
            <div class="row">
              <div class="col-md-4 col-sm-12 col-form">
                <label for="sl-vous" class="lb-form">Vous êtes</label>
              </div>
              <div class="col-md-8 col-sm-12 col-form">
                <select id="sl-vous" class="ipt ipt-normal">
                  <option value="particulier">Particulier</option>
                  <option value="professionnel">Professionnel</option>
                  <option value="association">Association</option>
                </select>
              </div>
            </div>
          </div>
          <!-- END -->
          <div class="col-md-6 col-sm-12 col-form">
            <div id="societe" class="row {!! Form::hasError('societe', $errors) !!}">
              <div class="col-md-4 col-sm-12 col-form">
                <label for="societe" class="lb-form">Société</label>
              </div>
              <div class="col-md-8 col-sm-12 col-form">
                {!! Form::text('societe', null, ['class' => 'ipt ipt-normal form-control']) !!}
                {!! Form::errorMsg('societe', $errors, ['class' => 'invalid-feedback']) !!}
              </div>
            </div>

            <div id="association" class="row {!! Form::hasError('association', $errors) !!}">
              <div class="col-md-4 col-sm-12 col-form">
                <label for="association" class="lb-form">Association</label>
              </div>
              <div class="col-md-8 col-sm-12 col-form">
                {!! Form::text('association', null, ['class' => 'ipt ipt-normal form-control']) !!}
                {!! Form::errorMsg('association', $errors, ['class' => 'invalid-feedback']) !!}
              </div>
            </div>
          </div>
          <!-- END -->
        </div>
        <!-- END -->
        <div class="form-group row">
          <div class="col-md-6 col-sm-12 col-form {!! Form::hasError('nom', $errors) !!}">
            <div class="row">
              <div class="col-md-4 col-sm-12 col-form">
                <label for="nom" class="lb-form">Nom <i class="required-field">*</i></label>
              </div>
              <div class="col-md-8 col-sm-12 col-form">
                {!! Form::text('nom', null, ['class' => 'ipt ipt-normal form-control']) !!}
                {!! Form::errorMsg('nom', $errors, ['class' => 'invalid-feedback']) !!}
              </div>
            </div>
          </div>
          <!-- END -->
          <div class="col-md-6 col-sm-12 col-form {!! Form::hasError('code_postal', $errors) !!}">
            <div class="row">
              <div class="col-md-4 col-sm-12 col-form">
                {!! Form::label('code_postal', 'Code postal', array('class' => 'lb-form')) !!}
                <!-- <label for="code_postal" class="lb-form">Code postal</label> -->
              </div>
              <div class="col-md-8 col-sm-12 col-form">
                {!! Form::number('code_postal', '', array('class' => 'ipt ipt-normal form-control')) !!}
                {!! Form::errorMsg('code_postal', $errors, ['class' => 'invalid-feedback']) !!}
              </div>
            </div>
          </div>
          <!-- END -->
        </div>
        <!-- END -->
        <div class="form-group row">
          <div class="col-md-6 col-sm-12 col-form {!! Form::hasError('prenom', $errors) !!}">
            <div class="row">
              <div class="col-md-4 col-sm-12 col-form">
                <label for="prenom" class="lb-form">Prénom <i class="required-field">*</i></label>
              </div>
              <div class="col-md-8 col-sm-12 col-form">
                {!! Form::text('prenom', null, ['class' => 'ipt ipt-normal form-control']) !!}
                {!! Form::errorMsg('prenom', $errors, ['class' => 'invalid-feedback']) !!}
              </div>
            </div>
          </div>
          <!-- END -->
          <div class="col-md-6 col-sm-12 col-form {!! Form::hasError('ville', $errors) !!}">
            <div class="row">
              <div class="col-md-4 col-sm-12 col-form">
                {!! Form::label('ville', 'Ville', array('class' => 'lb-form')) !!}
              </div>
              <div class="col-md-8 col-sm-12 col-form">
                {!! Form::text('ville', '', array('class' => 'ipt ipt-normal')) !!}
                {!! Form::errorMsg('ville', $errors, ['class' => 'invalid-feedback']) !!}
              </div>
            </div>
          </div>
          <!-- END -->
        </div>
        <!-- END -->
        <div class="form-group row">
          <div class="col-md-6 col-sm-12 col-form {!! Form::hasError('email', $errors) !!}">
            <div class="row">
              <div class="col-md-4 col-sm-12 col-form">
                <label for="email" class="lb-form">Email <i class="required-field">*</i></label>
              </div>
              <div class="col-md-8 col-sm-12 col-form">
                {!! Form::text('email', null, ['class' => 'ipt ipt-normal form-control']) !!}
                {!! Form::errorMsg('email', $errors, ['class' => 'invalid-feedback']) !!}
              </div>
            </div>
          </div>
          <!-- END -->
          <div class="col-md-6 col-sm-12 col-form {!! Form::hasError('phone', $errors) !!}">
            <div class="row">
              <div class="col-md-4 col-sm-12 col-form">
                {!! Form::label('phone', 'Téléphone', array('class' => 'lb-form')) !!}
              </div>
              <div class="col-md-8 col-sm-12 col-form">
                {!! Form::number('phone', '', array('class' => 'ipt ipt-normal form-control')) !!}
                {!! Form::errorMsg('phone', $errors, ['class' => 'invalid-feedback']) !!}
              </div>
            </div>
          </div>
          <!-- END -->
        </div>
        <!-- END -->
        <div class="form-group">
          <label class="lb-form">J’accepte de revoir des communications email de la part de Lilial</label>
          <div class="grp-radio">
            <label class="txt on">OUI</label>
            <div class="wrap">
              <input type="checkbox" name="get_info" id="getInfo" class="ipt-checkbox" hidden=""><div is="0" class="btn-group" tabindex="0"><a is="0" class="btn active btn-danger">No</a><a is="1" class="btn btn-default">Yes</a></div>
            </div>
            <label class="txt">NON</label>
          </div>
        </div>
        <!-- END  -->
        <div class="form-group row {!! Form::hasError('comment', $errors) !!}">
          <div class="col-md-2 col-sm-12 col-form">
            <label for="message" class="lb-form">Votre message <i class="required-field">*</i></label>
          </div>
          <div class="col-md-10 col-sm-12 col-form">
            {!! Form::textarea('comment', null, ['class' => 'ipt txtarea form-control']) !!}
            {!! Form::errorMsg('email', $errors, ['class' => 'invalid-feedback']) !!}
          </div>
        </div>
        <!-- END -->
        <div class="form-group text-right">
          <div class="capcha-wrap {!! Form::hasError('g-recaptcha-response', $errors) !!}">
            {{-- <img src="{{ asset('front/uploads/captcha.png') }}" alt=""> --}}
            {!! NoCaptcha::display() !!}
            {!! Form::errorMsg('g-recaptcha-response', $errors, ['class' => 'invalid-feedback']) !!}
          </div>
          <div class="btn-wrap">
            {!! Form::submit('Envoyer', array('class' => 'btn btn-green')) !!}
            <!-- <button class="btn btn-green">Envoyer</button> -->
          </div>
        </div>
        <!-- END -->
      {!! Form::close() !!}
    </div>
  </div>
  <!-- END: FORM-->
  @include('front.includes.home-logo')
  <!-- END: HOME LOGO-->
  @include('front.includes.block')
  <!-- END: BLOCK-->
</div>
@inject('setting', 'App\Services\Content\SettingService')
<div class="hotline-side">
  <div class="hotline-desc"> <span class="sml">RAPPEL</span><span class="lrg">GRATUIT !</span></div><a href="{{ 'tel:'.$setting->get('company.phone') }}" class="hot-click"><i style="background-image: url('{{$actual_link}}/front/uploads/icons/ico-phone-w.png')" class="ico"></i></a>
</div>
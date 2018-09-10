@if(isset($route))
    <a href="{{$route}}" target="{{isset($target) ? $target : '_blank'}}">
@endif
        <img src="{!! $model->media($relation, 2, 80) !!}" height="80">
@if(isset($route))
    </a>
@endif
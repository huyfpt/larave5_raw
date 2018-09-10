<a href="{{ URL::to('/faqs')}}" class="faqs-active" data-id="0">{{'Afficher tout'}}</a>
@if(count($categories))
@foreach($categories as $category)
    <a href="/faqs/category/" data-id="{{$category->id}}">{{$category->label}}</a>
@endforeach
@endif
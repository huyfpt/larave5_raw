@inject('repository', 'Hegyd\News\Repositories\Contracts\NewsRepositoryInterface')

<div class="col-md-3 news-cat-panel">
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('hegyd-news::news_categories.title.index')
            <div class="panel-action"><a href="#" data-perform="panel-collapse"><i class="ti-plus"></i></a></div>
        </div>
        <div class="panel-wrapper collapse in">
            <div class="white-box">
                <ul class="basic-list list-cat">
                    @foreach($categories as $cat)
                        @php
                            if($can_edit_category)
                            {
                                $count = $repository->getByCategory($cat->id, true);
                            }else{
                                $count = $repository->getActiveByCategory($cat->id, true);
                            }
                        @endphp
                        <li>
                            <a href="{{ $cat->url() }}" class="{{ $cat->active ? '' : 'text-danger' }}">
                        <span class="txt">
                        @if(!$cat->active)
                                <i class="fa fa-eye-slash"></i>
                            @endif
                            {{$cat->name}}
                        </span>
                                <span class="pull-right label {{ $count ? 'label-info' : 'label-default' }}">{{ $count }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
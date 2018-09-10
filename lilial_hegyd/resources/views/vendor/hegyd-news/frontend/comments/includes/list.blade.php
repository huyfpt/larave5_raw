@if(config('hegyd-news.enable_comment') && $news->enable_comment)
    @php
        $comments = $news->comments()->where('active', true)->get();
    @endphp
    <div class="list-comment comment-ldlc row row-grey">
        <div class="row">
            <div class="comment-items">
                @include('hegyd-news::app.frontend.comments.includes.list_comments')
            </div>
        </div>
    </div>

    <div id="modal" class="modal fade" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
            </div>
        </div>
    </div>
@endif

@push('scripts')
    {!! Html::script('/vendor/hegyd/news/js/hegyd.js') !!}
    {!! Html::script('/vendor/hegyd/news/js/frontend/comments/index.js') !!}
@endpush


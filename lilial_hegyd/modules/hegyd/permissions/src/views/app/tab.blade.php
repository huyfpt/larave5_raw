<div class="panel-body">
    @foreach($root->children as $category)
        @include('hegyd-permissions::table')
    @endforeach
</div>
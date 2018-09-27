@extends('partials.main')

@section('content')

<div class="row">
    <div class="col-md-10">
            <h2>All Post</h2>
        <table class="table">
            <thead>
                <th>#</th>
                <th>Title</th>
                <th>Description</th>
                <th>Create at</th>
                <th>Action</th>
            </thead>
            <tbody>
                @foreach ($posts as $key => $post)
                <tr>
                    <td><strong>{{($key + 1)}}</strong></td>
                    <td>{{$post->title}}</td>
                    <td>{{ substr($post->body, 0 , 50) }}{{ strlen($post->body) > 50 ? "..." : "" }}</td>
                    <td>{{date('M j, Y H:i', strtotime($post->created_at))}}</td>
                    <td>
                        {!! Html::linkRoute('posts.show', 'View',[$post->id], ['class' => 'btn btn-default']) !!}
                        {!! Html::linkRoute('posts.edit', 'Update',[$post->id], ['class' => 'btn btn-primary']) !!}
                        {!! Form::open(['route' => ['posts.destroy', $post->id], 'method' => 'DELETE']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-center">{!! $posts->links() !!}</div>
    </div>
    <div class="col-md-2">
        <a href="{{route('posts.create')}}" class="btn btn-primary btn-h1-spacing">Create New post</a>
    </div>
</div>

@endsection
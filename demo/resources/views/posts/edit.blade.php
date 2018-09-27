@extends('partials.main')

@section('title', 'Update a post')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <p class="lead">Update Post</p>
        <hr>
        {!! Form::model($post, ['route' => ['posts.update', $post->id] , 'method' => 'PUT' ]) !!}
        {!! Form::label('title', 'Title: ') !!}
        {!! Form::text('title', null , ['class' => 'form-control input-lg']) !!}

        {!! Form::label('body', 'Description', ['class' => 'form-spacing-top']) !!}
        {!! Form::textarea('body', null, ['class' => 'form-control']) !!}
        <div class="card">
            <div class="card-body">
              <h6 class="card-subtitle mb-2 text-muted">Date created: {{date('M j, Y H:i', strtotime($post->created_at)) }}</h6>
                <div class="row">
                    <div class="col-sm-6">
                        {!! Html::linkRoute('posts.show', 'Cancel',[$post->id], ['class' => 'btn btn-danger btn-block']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::submit('Save change', ['class' => 'btn btn-primary btn-block']) !!}
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

@endsection
@extends('partials.main')

@section('title', 'Detail a post')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <p class="lead">This is detail blog recent created</p>
        <hr>
        <div class="card">
            <div class="card-body">
            <h5 class="card-title">Post title: {{$show->title}}</h5>
              <h6 class="card-subtitle mb-2 text-muted">Date created: {{date('M j, Y H:i', strtotime($show->created_at)) }}</h6>
            <p class="card-text">Description: {{$show->body}}</p>
            <div class="row">
                <div class="col-sm-6">
                    {!! Html::linkRoute('posts.edit', 'Edit',[$show->id], ['class' => 'btn btn-primary btn-block']) !!}
                </div>
                <div class="col-sm-6">
                    {!! Html::linkRoute('posts.destroy', 'Delete',[$show->id], ['class' => 'btn btn-danger btn-block']) !!}
                </div>
            </div>
              {{-- <a href="#" class="card-link">Card link</a> --}}
            </div>
        </div>
    </div>
</div>

@endsection
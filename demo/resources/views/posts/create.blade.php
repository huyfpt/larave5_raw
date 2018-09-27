@extends('partials.main')

@section('title', '| Create new Post')

@section('stylesheets')
        {!! Html::style('css/parsley.css') !!}
@endsection

@section('content')

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h1>Create new Post</h1>
        <hr>
        {!! Form::open(['route' => 'posts.store', 'data-parsley-validate' => '']) !!}
            {{Form::label('title', 'Title: ')}}
            {{Form::text('title', null ,array('class' => 'form-control', 'required' => ''))}}
            {{Form::label('body', 'Post Body: ')}}
            {{Form::textarea('body', null ,array('class' => 'form-control' , 'required' => ''))}}
            {{Form::submit('Create post', array('class' => 'btn btn-primary btn-lg btn-block'))}}
        {!! Form::close() !!}
    </div>
</div>

@endsection

@section('script')
        {!! Html::script('js/parsley.min.js') !!}
@endsection
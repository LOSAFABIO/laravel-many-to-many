@extends('layouts.app')

@section('title','lista posts')

@section('content')
  <h1>{{$post->title}}</h1>
  <p>{!!$post->content!!}</p>
  <p>{{$post->author}}</p>

  <a href="{{route("admin.posts.index")}}">
    <button type="button" class="btn btn-primary">Torna ai post</button>
  </a>
  <form action="{{route("admin.posts.destroy", $post->id)}}" method="POST">
    @csrf
    @method("DELETE")
    <button onclick="return confirm('Sicuro di voler cancellare questo post?');" type="submit" class="btn btn-danger">Cancella</button>
  </form>
@endsection
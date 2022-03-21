@extends('layouts.app')

@section('title','lista posts')

@section('content')
<div class="container">
  <div class="d-flex flex-column align-items-center">
    <h3>Titolo : </h3><p>{{$post->title}}</p>
    <h3>Contenuto : </h3><p>{!!$post->content!!}</p>
      <h3>Autore : </h3><p>{{$post->author}}</p>
    <a href="{{route("admin.posts.index")}}">
      <button type="button" class="btn btn-primary my-1">Torna ai post</button>
    </a>
    <form action="{{route("admin.posts.destroy", $post->id)}}" method="POST">
      @csrf
      @method("DELETE")
      <button onclick="return confirm('Sicuro di voler cancellare questo post?');" type="submit" class="btn btn-danger my-1">Cancella</button>
    </form>
  </div>
</div>
@endsection
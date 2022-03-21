@extends('layouts.app')

@section('title','lista post')

@section('content')
<table class="table">
  <thead>
      <tr class="bg-primary text-white">
        <th scope="col">#</th>
        <th scope="col">Titolo</th>
        <th scope="col">Contenuto</th>
        <th scope="col">Data_post</th>
        <th scope="col">Autore</th>
        <th scope="col">Slug</th>
        <th scope="col">Categoria</th>
        <th scope="col">Tag</th>
        <th scope="col">Mostra</th>
        <th scope="col">Modifica</th>
        <th scope="col">Elimina</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($posts as $elemento)
        <tr class="bg-light">
          <th scope="row">{{$elemento->id}}</th>
          <td>{{$elemento->title}}</th>
          <td>{!!$elemento->content!!}</th>
          <td>{{$elemento->post_date}}</th>
          <td>{{$elemento->author}}</th>
          <td>{{$elemento->slug}}</th>
          <td>{{$elemento->category? $elemento->category->name : '-'}}</th>
          <td>
            @foreach ($elemento->tags as $tag)
                {{$tag->name}} <br> 
            @endforeach
          </th>
          <td>
            <a href="{{route("admin.posts.show", $elemento->id)}}"><button type="button" class="btn btn-primary">Mostra</button></a>
          </th>
          <td>
            <a href="{{route("admin.posts.edit", $elemento->id)}}"><button type="button" class="btn btn-success">Modifica</button></a>
          </th>
          <td>
              <form action="{{route("admin.posts.destroy", $elemento->id)}}" method="POST">
                @csrf
                @method("DELETE")
                <button onclick="return confirm('Sicuro di voler cancellare questo post?');" type="submit" class="btn btn-danger">Cancella</button>
              </form>
          </th>
        </tr>
        @endforeach
      </tbody>
      <a href="{{route("admin.posts.create")}}"><button type="button" class="btn btn-warning my-2">Crea nuovo</button></a>
      <a href="{{route("admin.home")}}"><button type="button" class="btn btn-secondary m-2">Torna alla dashboard</button></a>
  </table>
@endsection
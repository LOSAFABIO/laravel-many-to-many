@extends('layouts.app')

@section('title','lista post')

@section('content')
    <h1>Crea un tuo post:</h1>
    <form action="{{route("admin.posts.store")}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Titolo</label>
            <input type="text" class="form-control" id="title" aria-describedby="title" name="title" placeholder="Inserisci titolo" value="{{old("title")}}">
            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="content">Contenuto</label>
            <textarea class="form-control" id="content" name="content" rows="3">{{old("content")}}</textarea>
            @error('content')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="post_date">Data_post</label>
            <input type="date" class="form-control-file" id="post_date" name="post_date">
            @error('post_date')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="author">Autore</label>
            <input type="text" class="form-control" id="author" aria-describedby="price" name="author" placeholder="Inserisci autore" value="{{old("author")}}">
            @error('author')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="category">Categoria</label>
            <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                <option value="">-- seleziona una categoria --</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{$category->id == old('category_id') ? 'selected' : '-' }} >
                    {{$category->name}}
                </option>
                @endforeach
            </select>
            @error('category_id')   
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-check">
            <p for="">Tags</p>
            @foreach ($tags as $tag)
                <input class="form-check-input" type="checkbox" value="{{$tag->id}}" id="{{$tag->slug}}" name="tags[]">
                <label class="form-check-label" for="{{$tag->slug}}"
                    {{$tag->id == old('tag_id') ? 'selected' : '-' }} >
                    {{$tag->name}}
                </label>
            @endforeach
            @error('tag_id')   
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <a href="{{route("admin.posts.index")}}">
            <button type="button" class="btn btn-primary">Torna indietro</button>
        </a>
        <a href="{{route("admin.posts.index")}}">
            <button type="submit" class="btn btn-success">Salva</button>
        </a>
    </form>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
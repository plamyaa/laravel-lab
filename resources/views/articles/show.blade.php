@extends('layouts.layout')
@section('content')
<div class="card" style="margin-top;">
  <div class="card-body">
    <h5 class="card-title">{{$article->name}}, ({{$article->date}})</h5>
    <h6 class="card-subtitle mb-2 text-muted">{{$article->shortDesc}}</h6>
    <p class="card-text">{{$article->desc}}</p>
    @can('create')
    <a href="/article/edit/{{$article->id}}" class="btn btn-info">Редактировать</a>
    <a href="/article/destroy/{{$article->id}}" class="btn btn-warning">Удалить</a>
    @endcan
  </div>

  @isset($_GET['result'])
  @if($_GET['result'])
  <div class="alert alert-secondary">
    Ваш комментарий ожидает модерации!
  </div>
  @endif
  @endisset
  <h3 class="text-center">Комментарии</h3>
  @foreach($comments as $comment)
  <form action="/comment/{{$comment->id}}" method="post">
    @method('DELETE')
    @csrf
    <div class="card-body">
    <h5 class="card-title">{{$comment->title}}</h5> <h6>({{$comment->created_at}})</h6>
    <h6 class="card-subtitle mb-2 text-muted">{{$comment->text}}</h6>
    @can('update-comment', $comment)
      <a href="/comment/{{$comment->id}}/edit" class="btn btn-secondary">Редактировать</a>
      <!-- <a href="/comment/{{$comment->id}}" class="btn btn-secondary">Удалить</a> -->
      <button type="submit" class="btn btn-danger">Удалить</button>
    @endcan
  </div>
  </form>
  
  @endforeach
  {{$comments->links()}}
</div>

@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
            <li>
            {{$error}} 
            </li>
        @endforeach 
    </ul>
</div>
@endif

<form action="/comment" method="POST">
    @csrf
   <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Заголовок</label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="title" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Описание</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="text">
  </div>
  <input type="hidden" name="id" value="{{$article->id}}">
  <button type="submit" class="btn btn-primary">Добавить новый комментарий</button>
</form>
@endsection
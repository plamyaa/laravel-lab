@extends('layouts.layout')
@section('content')
<form action="/comment/{{$comment->id}}" method="POST">
    @method('PUT')
    @csrf
   <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Заголовок</label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="title" aria-describedby="emailHelp" value="{{$comment->title}}">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Описание</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="text" value="{{$comment->text}}">
  </div>
  <button type="submit" class="btn btn-primary">Изменить</button>
</form>
@endsection
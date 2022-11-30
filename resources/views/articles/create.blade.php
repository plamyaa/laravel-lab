@extends('layouts.layout')
@section('content')

<form action="/article/store" method="post">
  @csrf
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Дата</label>
    <input type="date" class="form-control" id="exampleInputEmail1" name="date" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Имя статьи</label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="name" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Аннотация</label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="annotation" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Описание</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="description">
  </div>
  <button type="submit" class="btn btn-primary">Создать</button>
</form>
@endsection

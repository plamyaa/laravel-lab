@extends('layouts.layout')
@section('content')
<table class="table">
  <thead>
    <tr>
      <th scope="col">Date</th>
      <th scope="col">Article</th>
      <th scope="col">Title</th>
      <th scope="col">Text</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    @foreach($comments as $comment)
    <tr>
      <th scope="row">{{$comment->create_at}}</th>
      <td><a href="/article/show/{{$comment->article_id}}">{{App\Models\Article::where('id', $comment->article_id)->value('name')}}</a></td>
      <td>{{$comment->title}}</td>
      <td>{{$comment->text}}</td>
      <td>
        <a class="btn" href="/comment/{{$comment->id}}/accept">Принять</a>
        <a class="btn" href="/comment/{{$comment->id}}/reject">Отклонить</a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
{{$comments->links()}}
@endsection
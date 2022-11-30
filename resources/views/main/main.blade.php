@extends('layouts.layout')
@section('content')
<table class="table">
  <thead>
    <tr>
      <th scope="col">Date</th>
      <th scope="col">Title</th>
      <th scope="col">Desc</th>
      <th scope="col">Image</th>
    </tr>
  </thead>
  <tbody>
    @foreach($articles as $article)
    <tr>
      <th scope="row">{{$article['date']}}</th>
      <td>{{$article['name']}}</td>
      <td>{{$article['desc']}}</td>
      <td>
        <a href="galery/{{$article['full_image']}}">
          <img src="{{URL::asset($article['preview_image'])}}" alt="" height="100" width="100">
        </a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection
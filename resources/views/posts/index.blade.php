@extends('layouts.app')

@section('content')
@foreach($posts as $post)
<div class="card" style="margin-top: 10px;">
  <input type="hidden" name="post_id" value="{{ $post->id }}">
  <div class="card-body">
    <h5 class="card-title">{{$post->title}}</h5>
    <p class="card-text">{{ $post->description }}</p>
    <a href="{{ route('posts.show', $post->id) }}"><button type="button" class="btn btn-success" style="margin-right: 5px">More</button></a>
  </div>
</div>
@endforeach
@endsection

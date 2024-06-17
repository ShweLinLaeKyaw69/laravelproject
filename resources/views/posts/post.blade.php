@extends('layouts.app')
@section('content')

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
<div class="content-container">
    @if(count($errors)>0)
    @foreach ($errors->all() as $error)
    <p class="alert alert-warning">{{ $error }}</p>
    @endforeach
    @endif

    <div id="contact" class="contact-area section-padding">
        <div class="container" >										
            <div class="section-title text-center">
                <h1>{{ $post->title }}</h1>
                <h4>by {{ $post->user->name}}</h4>
                <p>{{ $post->description }}</p>
            </div>					
        </div>
    </div>
</div>

<div class="container">
<div class="content-container">
    <div class="content-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('comment.store', $post->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                @if($errors->has('title'))
                        <div>
                                <p>{{ $errors->first('title') }}</p>
                        </div>
                                @endif
                        <div>
                            <textarea name="comment" class="form-control" id="comment" placeholder="Comment"></textarea>
                        </div>
                            @if($errors->has('comment'))
                            <div>
                                <p>{{ $errors->first('comment') }}</p>
                            </div>
                            @endif
                                @if($errors->has('public_flag'))
                                    <div>
                                        <p>{{ $errors->first('public_flag') }}</p>
                                    </div>
                                @endif
                                    <div style="text-align: center">
                                        <a href=""><button type="submit" class="btn btn-info" style="margin-top:5px;">Comment</button></a>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="content-container" style="margin-top: 10px">
        @if(count($post->comments) != 0)
        @foreach($post->comments as $comment)
        <div class="card" style="margin-top: 5px;">
            <div class="card-body">
              <h6 class="card-title"><a class="comment-user" href="{{route('users.showdetail', $comment->user->id)}}">by {{ $comment->user->name }}</a></h6>
              <p class="card-text"  id="{{'text-comment-id_'.$comment->id}}">{{ $comment->comment }}</p>
              <a href="{{ route('comment.edit', $comment->id,$comment->post_id) }}" class="edit-comment comment-inner" rel="edit" id="{{'edit-comment-id_'.$comment->id}}">Edit</a>
                <br>
              <a href="{{ route('comment.delete', $comment->id) }}"><button type="button" class="btn btn-danger" style="margin-left: 2px;">Delete</button></a>
            </div>
          </div>
          @endforeach
         @endif
    </div>
</div>
@endsection




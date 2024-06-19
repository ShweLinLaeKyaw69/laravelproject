@extends('layouts.app')
@section('content')
<div class="content-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header ">{{ __('Edit Post') }}</div>
                    <div class="card-body">
                        <form action="{{ route('posts.update') }}" method="POST">
                         @csrf
                    <div>
                        <input type="hidden" value="{{ $post->user_id }}" name="user_id" id="user_id">
                        <input type="hidden" value="{{ $updated_by }}" name="updated_by" id="updated_by">
                        <input type="hidden" value="{{ $post->id }}" name="id" id="id">
                    </div>
                <div>
                        <label for="title">Title</label><br>
                        <input id="title" class="form-control" name="title" value="{{ $errors->any()?old('post'):$post->title }}">
                </div>
                    @if ($errors->has('title'))
                        <div>
                            <p>{{ $errors->first('title') }}</p>
                        </div>
                    @endif
                 <div>
                    <label for="description">Description</label><br>
                    <textarea id="description" class="form-control" name="description">{{ $errors->any()?old('description'):$post->description }}</textarea>
                 </div>
                      @if($errors->has('description'))
                        <div>
                            <p>{{ $errors->first('description') }}</p>
                        </div>
                      @endif
                            <div style="margin-top: 10px"><button type="submit" class="btn btn-info">Update</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


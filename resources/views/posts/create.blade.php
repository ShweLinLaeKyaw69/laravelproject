@extends('layouts.app')
@section('content')
<div class="content-container">
    <div class="content-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header ">{{ __('Upload Post') }}</div>
                        <div class="card-body">
    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
        <div>
            <input type="hidden"  value="{{ $user_id }}" name="user_id" id="user_id">
        </div>
        <div>
            <label for="title">Title</label><br>
            <input name="title" class="form-control" id="title" value="{{ old('title') }}">
        </div>
        @if($errors->has('title'))
        <div>
            <p>{{ $errors->first('title') }}</p>
        </div>
        @endif
        <div>
            <label for="description">Description</label><br>
            <textarea name="description" class="form-control" id="description" placeholder="Description">{{ old('description') }}</textarea>
        </div>
        @if($errors->has('description'))
        <div>
            <p>{{ $errors->first('description') }}</p>
        </div>
        @endif
        @if($errors->has('public_flag'))
        <div>
            <p>{{ $errors->first('public_flag') }}</p>
        </div>
        @endif
        <div>
            <div style="margin-top: 10px"><button type="submit" class="btn btn-success">Post</button></div>
        </div>
    </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<a href="{{route('posts.postindex', Auth::user()->id)}}" style="margin-left: 20px">Back</a>


@endsection

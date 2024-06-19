@extends('layouts.app')

@section('content')
<a href="{{route('posts.postindex', Auth::user()->id)}}" style="margin-left: 20px">Back</a>

<div class="content-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Comment') }}</div>
                    <div class="card-body">
                        <form action="{{ route('comment.update', $comment->id,$comment->posts_id) }}" method="POST">
                            @csrf
                            
                            <div>

                                <input type="hidden" value="{{ $comment->id }}" name="id" id="id">
                            </div>
                
                            <div>
                                <label for="comment">Comment</label><br>
                                <textarea id="comment" class="form-control" name="comment">{{ $errors->any() ? old('comment') : $comment->comment }}</textarea>
                            </div>
                            <a href="comment.update"><button type="submit" class="btn btn-info" style="margin-right: 10px; margin-top:10px;">Update</button></a>
                            {{-- <div style="margin-top: 10px"><button type="submit" class="btn btn-info">Update</button></div> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

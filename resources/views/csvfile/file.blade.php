@extends('layouts.app')

@section('content')
<a href="{{route('posts.postindex', Auth::user()->id)}}" style="margin-left: 20px">Back</a>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('CSV File Download') }}</div>

                <div class="card-body">
                    <form method="GET" action="{{ route('file.file.csv.posts.download') }}">
                        @csrf
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Download CSV File') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container" style="margin-top: 10px">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('CSV File Upload') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('file.file.csv.posts.upload') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{ Auth::id() }}" name="user_id"> <!-- Use Auth::id() to get user ID -->
                        <label for="posts_csv">Select CSV file for posts</label>
                        <input name="posts_csv" id="posts_csv" type="file" accept=".xlsx, .xls, .csv" style="margin-left:50px;">
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4" style="margin-top: 20px">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Upload CSV File') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                @if($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @elseif($message = Session::get('failed'))
            <div class="alert alert-danger">
                <p>{{ $message }}</p>
            </div>
        @endif
            </div>
        </div>
    </div>
</div>

@endsection

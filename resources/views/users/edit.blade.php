@extends('layouts.app')
@section('content')
<div class="content-container">
    <form enctype="multipart/form-data" action="{{ route('users.update') }}" method="POST">
        @csrf
        @if(count($errors)>0)
            @foreach ($errors->all() as $error)
                <p class="alert alert-warning">{{ $error }}</p>
            @endforeach
        @endif
        <div class="form-ttl" style="text-align: center;">
            <h3>Edit User</h3>
        </div>
        <div>
            <input name="id" name="id" id="id" type="hidden" @if ($errors->any()) value="{{old('id')}}" @else value="{{ $user->id }}" @endif>
        </div>
        <div>
            <label for="email">Email</label><br>
            <input type="email" name="email" id="email"  class="form-control" placeholder="Email" @if ($errors->any()) value="{{old('email')}}" @else value="{{ $user->email }}" @endif>
        </div>
        @if ($errors->has('email'))
        <div>
            <p>{{ $errors->first('email') }}</p>
        </div>
        @endif
        <div>
            <label for="name">Name</label><br>
            <input type="text" name="name" id="name" placeholder="Name" class="form-control" @if ($errors->any()) value="{{old('name')}}" @else value="{{ $user->name }}" @endif>
        </div>
        @if ($errors->has('name'))
        <div>
            <p>{{ $errors->first('name') }}</p>
        </div>
        @endif

        @if ($message = Session::get('error'))
        <div>
            <p>{{ $message }}</p>
        </div>
        @endif
        <div class="form-submit-btn" style="margin-top: 10px; text-align: center;">
            <button type="submit" class="btn btn-primary" style="margin-right: 10px">Update</button>
        
        <a href="{{ route('users.delete', $user->id) }}"><button type="button" class="btn btn-danger">Delete</button></a></div>
    </form>

    <div style="text-align: center; margin-top:10px;">
        <a href="{{ route('changePasswordScreen', $user->id) }}">Change Password</a>
    </div>
</div>
@endsection


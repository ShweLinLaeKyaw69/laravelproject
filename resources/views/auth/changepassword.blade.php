@extends('layouts.app')
@section('content')
<div class="content-container">
    <form action="{{ route('changePassword') }}" method="POST">
        @csrf
        <div class="form-ttl">
            <h3>Change Password</h3>
        </div>
        <div><input type="hidden" value="{{$user->id}}"></div>
        <div>
            <label for="current_password">Current Password</label><br>
            <input type="password" id="current_password" name="current_password" placeholder="Current Password">
        </div>
        @if ($errors->has('old_password'))
        <div>
            <p>{{ $errors->first('old_password') }}</p>
        </div>
        @endif
        <div>
            <label for="new_password">New Password</label><br>
            <input type="password" id="new_password" name="new_password" placeholder="New Password">
        </div>
        @if ($errors->has('new_password'))
        <div>
            <p>{{ $errors->first('new_password') }}</p>
        </div>
        @endif
        <div>
            <label for="old_password">Confirm New Password</label><br>
            <input type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirm New Password">
        </div>
        @if ($errors->has('new_password_confirmation'))
        <div>
            <p>{{ $errors->first('new_password_confirmation') }}</p>
        </div>
        @endif
        <div class="form-submit-btn">
            <button type="submit">Submit</button>
        </div>
    </form>
    @if(count($errors)>0)
    @foreach ($errors->all() as $error)
    <p>
        {{ $error }}
    </p>
    @endforeach
    @endif
</div>
@endsection

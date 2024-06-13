@extends('layouts.app')
@section('content')
<div class="content-container" style="text-align: center;">
    @if(count($errors)>0)
        @foreach ($errors->all() as $error)
          <p class="alert alert-warning">{{ $error }}</p>
        @endforeach
     @endif
    <h3 class="user-detail-ttl" style="margin-top: 20px">User Detail</h3>

    <div>User ID: {{ $user->id }}</div>
    <div>Name: {{ $user->name }}</div>
    <div>email: {{ $user->email }}</div>

</div>
@endsection


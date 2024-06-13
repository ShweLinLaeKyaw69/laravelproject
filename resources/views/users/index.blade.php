@extends('layouts.app')

@section('content')
<div class="content-container">
    @if($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @elseif($message = Session::get('failed'))
    <div class="alert alert-danger">
        <p>{{ $message }}</p>
    </div>
    @endif
    @if(count($errors)>0)
        @foreach ($errors->all() as $error)
            <p class="alert alert-warning">{{ $error }}</p>
        @endforeach
    @endif
    <div>
        <a href="{{ route('users.create') }}"><button type="button" class="btn btn-primary">Add User</button></a>
    </div>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">No.</th>
            <th scope="col">Email</th>
            <th scope="col">User Name</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->name }}</td>
                <td>
                    <a href="{{ route('users.detail', $user->id) }}"><button type="button" class="btn btn-secondary" style="margin-right:10px;">Detail</button></a>
                    <a href="{{ route('users.edit', $user->id) }}"><button type="button" class="btn btn-info">Edit</button></a>
                </td>
            </tr>
            @endforeach
        </tbody>
      </table>
</div>
@endsection


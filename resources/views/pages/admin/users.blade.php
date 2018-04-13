@extends('layouts.admin')

@section('title') Users @endsection

@section('adminContent')
  <h1>Users</h1>
  <table id="adminUsers" class="table table-hover">
    <thead>
      <tr>
        <td>No.</td>
        <td>Username</td>
        <td>Email</td>
        <td>Role</td>
        <td>Edit</td>
        <td>Delete</td>
      </tr>
    </thead>
    <tbody>
      @foreach ( $users as $user )
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>
            <form method="POST" action="{{ route('adminUserEdit') }}">
              {{ csrf_field() }}
              <input type="hidden" name="userID" value="{{ $user->userID }}">
              <select class="form-control" name="id">
                @foreach ( $roles as $role )
                  <option {{ $role->id == $user->userRole ? 'selected' : '' }} value="{{ $role->id }}">{{ $role->role_name }}</option>
                @endforeach
              </select>
          </td>
          <td>
            <button class="btn btn-primary" type="submit">Edit</button>
            </form>
          </td>
          <td>
            <form method="POST" action="{{ route('adminUserDestroy') }}">
              {{ csrf_field() }}
              <input type="hidden" name="id" value="{{ $user->userID }}">
              <button class="btn btn-danger" type="submit">Delete!</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
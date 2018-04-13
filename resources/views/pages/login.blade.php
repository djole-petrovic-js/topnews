@extends('layouts.main')

@section('title')
  Login
@endsection

@section('content')
  <h1>Log in</h1>
  <div class="row">
    @if ( isset($errors) && count($errors) > 0 )
      <ul class="list-group">
        @foreach ( $errors->all() as $e )
          <div class="alert alert-danger">
            {{ $e }}
          </div>
        @endforeach
      </ul>
    @endif
    @if ( session('error') )
      <div class="alert alert-danger">
        <p>{{ session('error') }}</p>
      </div>
    @endif
    <div class="col-md-7">
        <form method="POST" action="{{ route('loginUser') }}">
          {{ csrf_field() }}
          <div class="form-group">
            <input type="text" name="username" placeholder="Username..." class="form-control">
          </div>
          <div class="form-group">
            <input type="password" name="password" placeholder="Password..." class="form-control">
          </div>
          <div class="form-group">
            <input class="btn btn-primary" type="submit" name="submit" value="Login!">
          </div>
        </form>
    </div>    
  </div>
@endsection
@extends('layouts.main')

@section('title')Register @endsection

@section('content')
  <div class="row">
    @if ( $errors )
      <ul class="list-group">
        @foreach ( $errors->all() as $e )
          <div class="alert alert-danger">
            {{ $e }}
          </div>
        @endforeach
      </ul>
    @endif
    <div class="col-md-7">
      <h1>Register</h1>
        <div id="errorsdiv">
          
        </div>
        <form id="registerForm" method="POST" action="{{ route('registerUser') }}">
          {{ csrf_field() }}
          <div class="form-group">
            <input value="{{ old('username') }}" type="text" name="username" placeholder="Username..." class="form-control">
          </div>
          <div class="form-group">
            <input value="old('password')" type="password" name="password" placeholder="Password..." class="form-control">
          </div>
          <div class="form-group">
            <input value="{{ old('confirmPassword') }}" type="password" name="confirmPassword" placeholder="Confirm password..." class="form-control">
          </div>
          <div class="form-group">
            <input value="{{ old('email') }}" type="text" name="email" placeholder="Email..." class="form-control">
          </div>
          <div class="form-group">
            <input class="btn btn-primary" type="submit" name="submit" value="Register!">
          </div>
        </form>
    </div>    
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/form.js') }}"></script>
  <script src="{{ asset('js/register.js') }}"></script>
@endsection
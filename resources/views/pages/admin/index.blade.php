@extends('layouts.admin')

@section('adminContent')
  <div class="col-md-12" id="singlepost">
    <h1>Wellcome {{ $user->name }}</h1>
    <p>Info</p>
    <p>Email : {{ $user->email }}</p>
    <p>Account created : {{ date('d/m/Y',strtotime($user->created_at)) }}</p>
  </div>
@endsection
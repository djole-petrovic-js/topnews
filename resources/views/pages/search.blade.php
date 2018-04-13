@extends('layouts.main')

@section('title') Search @endsection

@section('meta')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
  <div class="container" id="container">
    <div class="row" id="articles">
      <div id="storiesWrapper" class="col-md-12">

      </div>
    </div>
    <div id="paginate" class="row">
      <div class="col-md-12">
        
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/attempt.js') }}"></script>
  <script src="{{ asset('js/checkTypes.js') }}"></script>
  <script src="{{ asset('js/search.js') }}"></script>
@endsection
@extends('layouts.main')

@section('title') Galery @endsection

@section('meta')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/lightbox.min.css') }}">
@endsection

@section('content')
  <h1>Galery</h1>
  <div class="images-wreaper">
    @if ( count($images) == 0 )
      <div class="alert alert-info">
        <p>There are no images for this story...</p>
      </div>
    @else
      @foreach ( $images as $image )
        <div class="col-md-3">
          <a href="{{ asset('uploads/' . $image->path) }}"
             data-lightbox='image-{{ $image->id }}' 
             data-title="image-{{ $image->id }}">
             <img class="img-responsive" src="{{ asset('uploads/' . $image->path) }}">
          </a>
        </div>
      @endforeach
    @endif
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/lightbox.js') }}"></script>
@endsection
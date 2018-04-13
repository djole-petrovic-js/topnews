@extends('layouts.admin')

@section('adminContent')
  <h1>Add new image</h1>
  <div class="col-md-5">
    <form method="POST" action="{{ route('adminSliderAdd') }}" enctype="multipart/form-data">
      {{ csrf_field() }}
      <div class="form-group">
        <input type="file" name="image" class="form-control">
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">Add!</button>
      </div>
    </form>
  </div>
  <div class="col-md-12">
    @if ( count($images) == 0 )
      <div class="alert alert-info">
        <p>No images for slider at the moment...</p>
      </div>
    @else
      <table class="table table-hover" id="galery-admin">
        <thead>
          <tr>
            <td>No.</td>
            <td>Image</td>
            <td>Delete</td>
          </tr>
        </thead>
        <tbody>
          @foreach ( $images as $image )
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td><img class="img-responsive" src="{{ asset('uploads/' . $image->path) }}"></td>
              <td>
                <form method="POST" action="{{ route('adminSliderDestroy') }}">
                  <input type="hidden" name="id" value="{{ $image->id }}">
                  {{ csrf_field() }}
                  <button class="btn btn-danger" type="submit">Delete</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>
@endsection
@extends('layouts.admin')

@section('adminContent')
  <div class="row">
    <div class="col-md-6">
      <h1>Add new image!</h1>
      <form method="POST" action="{{ route('adminGaleryAdd') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
          <select class="form-control" name="id">
            @foreach ( $stories as $story )
              <option value="{{ $story['id'] }}">{{ $story['title'] }}</option>
            @endforeach
          </select>
        </div>
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
          <p>No images at the moment...</p>
        </div>
      @else
        <table id="galery-admin" class="table table-hover">
          <thead>
            <tr>
              <td>No.</td>
              <td>Image</td>
              <td>Belongs to</td>
              <td>Delete</td>
            </tr>
          </thead>
          <tbody>
            @foreach ( $images as $image )
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td><img class="img-responsive" src="{{ asset('uploads/' . $image->path) }}"></td>
                <td>{{ $image->title }}</td>
                <td>
                  <form method="POST" action="{{ route('adminGaleryDestroy') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $image->id }}">
                    <input type="hidden" name="path" value="{{ $image->path }}">
                    <button class="btn btn-danger" type="submit">Delete!</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>
@endsection
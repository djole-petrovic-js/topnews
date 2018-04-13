@extends('layouts.admin')

@section('adminContent')
  <h1>Navigation Links</h1>
  <h2>Visibility</h2>
  <p>0 - For all users</p>
  <p>1 - Users without account</p>
  <p>2 - Registered users</p>
  <p>3 - For administators</p>
  <div class="row">
    <div class="col-md-6">
      <form method="POST" action="{{ route('adminLinksAdd') }}">
        <h2>Add a new Link</h2>
        {{ csrf_field() }} 
        <div class="form-group">
          <input type="text" name="href" placeholder="Link path (href)" class="form-control">
        </div>
        <div class="form-group">
          <input type="text" name="name" placeholder="Link name" class="form-control">
        </div>
        <div class="form-group">
          <input type="text" name="order" placeholder="Link order" class="form-control">
        </div>
        <div class="form-group">
          <input type="text" name="visibility" placeholder="Visibility of the link" class="form-control">
        </div>
        <div class="form-group">
          <input class="btn btn-primary" type="submit" name="submit" value="Add!">
        </div>
      </form>
    </div>
  </div>
  @if ( count($allLinks) == 0 )
    <div class="alert alert-info">
      <p>There are no links at the moment...</p>
    </div>
  @else
    <table class="table table-hover">
      <thead>
        <tr>
          <td>No</td>
          <td>Href</td>
          <td>Name</td>
          <td>Order</td>
          <td>Visibility</td>
          <td>Edit</td>
          <td>Delete</td>
        </tr>
      </thead>
      <tbody>
        @foreach ( $allLinks as $link )
          <tr>
            <form method="POST" action="{{ route('adminLinksEdit') }}">
              {{ csrf_field() }}
              <input type="hidden" name="id" value="{{ $link->id }}">
              <td>{{ $loop->iteration }}</td>
              <td><input type="text" name="href" value="{{ $link->href }}" class="form-control"></td>
              <td><input type="text" name="name" value="{{ $link->name }}" class="form-control"></td>
              <td><input type="text" name="order" value="{{ $link->link_order }}" class="form-control"></td>
              <td><input type="text" name="visibility" value="{{ $link->visibility }}" class="form-control"></td>
              <td>
                <button type="submit" class="btn btn-primary">Edit</button>
              </td>
            </form>
            <td>
              <form method="POST" action="{{ route('adminLinksDestroy') }}">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $link->id }}">
                <button type="submit" class="btn btn-danger">Delete</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
@endsection
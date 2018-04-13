@extends('layouts.admin')

@section('adminContent')
  <h1>Categories</h1>
  <div class="row">
    <div class="col-md-6">
      <form method="POST" action="{{ route('adminCategoriesAdd') }}">
        <h2>Add a new Categorie</h2>
        {{ csrf_field() }} 
        <div class="form-group">
          <input type="text" name="name" placeholder="Categorie Name..." class="form-control">
        </div>
        <div class="form-group">
          <input class="btn btn-primary" type="submit" name="submit" value="Add!">
        </div>
      </form>
    </div>
  </div>
  @if ( count($categories) == 0 )
    <div class="alert alert-info">
      <p>There are no categories at the moment...</p>
    </div>
  @else
    <table class="table table-hover">
      <thead>
        <tr>
          <td>No</td>
          <td>Name</td>
          <td>Edit</td>
          <td>Delete</td>
        </tr>
      </thead>
      <tbody>
        @foreach ( $categories as $categorie )
          <tr>
            <form method="POST" action="{{ route('adminCategoriesEdit') }}">
              {{ csrf_field() }}
              <input type="hidden" name="id" value="{{ $categorie->id }}">
              <td>{{ $loop->iteration }}</td>
              <td><input type="text" name="name" value="{{ $categorie->categorie_name }}" class="form-control"></td>
              <td>
                <button type="submit" class="btn btn-primary">Edit</button>
              </td>
            </form>
            <td>
              <form method="POST" action="{{ route('adminCategoriesDestroy') }}">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $categorie->id }}">
                <button type="submit" class="btn btn-danger">Delete</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
@endsection
@extends('layouts.admin')

@section('adminContent')
  <h1>Add New Story!</h1>

  <form action="{{ route('createNewStory') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-group">
      <input type="text" name="title" placeholder="Story title" class="form-control">
    </div>
    <div class="form-group">
      <input type="text" name="short_description" placeholder="Short Description" class="form-control">
    </div>
    <div class="form-group">
      <input type="file" name="image" class="form-control">
    </div>
    <div class="form-group">
      <select class="form-control" name="categorie_id">
        @foreach ( $categories as $categorie )
          <option value="{{ $categorie->id }}">{{ $categorie->categorie_name }}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <div id="paragraphs">
        
      </div>
      <div class="form-group">
        <span id="btnAddParagraph" class="btn btn-primary">Add Paragraph</span>
      </div>
    </div>
    <div class="form-group">
      <input type="submit" name="submit" value="Submit!" class="btn btn-primary">
    </div>
  </form>

  @if ( count($stories) == 0 )
    <div class="alert alert-info">
      <p>No stories at the moment.</p>
    </div>
  @else
    <table class="table table-hover" id="adminUsers">
      <thead>
        <tr>
          <td>No.</td>
          <td>Story</td>
          <td>Description</td>
          <td>Posted on :</td>
          <td>Category</td>
          <td>Edit</td>
          <td>Delete</td>
        </tr>
      </thead>
      <tbody>
        @foreach ( $stories as $story )
          <tr>
            <td>{{ $loop->iteration }}</td>
            <form method="POST" action="{{ route('adminStoriesEdit') }}">
              {{ csrf_field() }}
            <td><input name="title" type="text" class="form-control" value="{{ $story->title }}" /></td>
            <td><input name="description" type="text" class="form-control" value="{{ $story->description }}" /></td>
            <td>{{ date('d/m/Y',strtotime($story->created_at)) }}</td>
            <td>
              <select class="form-control" name="categorieID">
                @foreach ( $categories as $categorie )
                  <option {{ $categorie->id == $story->categoryID ? 'selected' : '' }} value="{{ $categorie->id }}">{{ $categorie->categorie_name }}</option>
                @endforeach
              </select>
            </td>
            <td>
              <input type="hidden" name="id" value="{{ $story->storyID }}"/>
              <button type="submit" class="btn btn-primary">Edit</button>
              </form>
            </td>
            <td>
              <form action="{{ route('adminStoriesDestroy') }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $story->storyID }}">
                <button type="submit" class="btn btn-danger">Delete</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
@endsection

@section('scripts')
  <script src="{{ asset('js/admin/categories.js') }}"></script>
@endsection
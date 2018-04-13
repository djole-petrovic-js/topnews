@extends('layouts.admin')

@section('adminContent')
  <h1>Paragraphs</h1>

  <div class="col-md-6">
    <form method="POST" action="{{ route('adminParagraphsMultiple') }}">
      {{ csrf_field() }}
      <div class="form-group">
        <h1>Story to show all paragraphs for : </h1>
        <select class="form-control" name="storyID">
          @foreach ( $stories as $story )
            <option value="{{ $story->id }}">{{ $story->title }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">Select</button>
      </div>
    </form>
  </div>

  @if ( isset($paragraphs) )
    <div class="col-md-12">
      <h1>Paragraphs for : {{ $singleStory->title }}</h1>
      <ul class="list-group">
        @foreach ( $paragraphs as $p )
          <li class="list-group-item" id="list-textareas">
            <form method="POST" action="{{ route('adminParagraphsEdit') }}">
            <textarea name="content" class="form-control textareas">
              {{ $p->content }}
            </textarea>
            
              {{ csrf_field() }}
              <input type="hidden" name="id" value="{{ $p->id }}">
              <button type="submit" class="btn btn-primary">Edit</button>
            </form>
            <br>
            <form method="POST" action="{{ route('adminParagraphsDestroy') }}">
              {{ csrf_field() }}
              <input type="hidden" name="id" value="{{ $p->id }}">
              <button class="btn btn-danger">Delete</button>
            </form>
          </li>
        @endforeach
      </ul>
    </div>
  @endif
  
@endsection

@section('scripts')
  <script src="{{ asset('js/admin/paragraphs.js') }}"></script>
@endsection
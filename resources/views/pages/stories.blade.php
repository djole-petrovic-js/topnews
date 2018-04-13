@extends('layouts.main')

@section('title') Stories @endsection

@section('content')
  <div class="row">
    <div class="col-md-8">
      <article id="singlepost">
        <h1>{{ $story['title'] }} | Rating(+{{ $story['likes'] }}|-{{ $story['dislikes'] }})</h1>
        <h2>{{ $story['description'] }}</h2>
        @if ( session('error') )
          <div class="alert alert-danger">
            <p>{{ session('error') }}</p>
          </div>
        @endif
        @if ( session('success') )
          <div class="alert alert-success">
            <p>{{ session('success') }}</p>
          </div>
        @endif
        <h2><a>Posted on : {{ date('d-m-Y',strtotime($story['created_at'])) }}</a></h2>
        <h2>View images for this story : <a href="{{ route('storiesGalery',$paragraphs[0]->story_id) }}">Here</a></h2>
        <div class="row">
          <div class="col-md-6">
            <img class="img-responsive" src="{{ '/public/uploads/' . $story['image'] }}"/>
            @if ( Auth::check() )
              <div class="col-md-2">
                <form method="POST" action="{{ route('LDCLike') }}">
                  {{ csrf_field() }}
                  <input type="hidden" name="id" value="{{ $story['story_id'] }}">
                  <button class="btn btn-primary">Like</button>
                </form>
              </div>
              <div class="col-md-2">
                <form method="POST" action="{{ route('LDCDisLike') }}">
                  {{ csrf_field() }}
                  <input type="hidden" name="id" value="{{ $story['story_id'] }}">
                  <button class="btn btn-danger">Dislike</button>
                </form>
              </div>
            @else
          <div class="alert alert-info">
            <p>You have to be logged in in order to vote</p>
          </div>
        @endif
          </div>  
        </div>
        <div class="row">
          @foreach ( $paragraphs as $p )
            <p>{{ $p->content }}</p>
          @endforeach
        </div>
      </article>
    </div>
    <div class="col-md-4">
      <h1>Comments</h1>
      @if ( Auth::check() )
        <h2>Add new comment</h2>
        <form method="POST" action="{{ route('storiesComment') }}">
          {{ csrf_field() }}
          <input type="hidden" name="id" value="{{ $story['story_id'] }}">
          <div class="form-group">
            <textarea name="content" class="form-control">
              
            </textarea>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Add Comment!</button>
          </div>
        </form>
      @else
        <h2>You have to be logged in to comment!</h2>
      @endif

      @foreach ( $comments as $comment )
        <div class="row">
          <div class="col-md-12 comment">
            <p>Posted By : {{ $comment->name }} on {{ date('d/m/Y',strtotime($comment->created_at)) }}</p>
            <p>{{ $comment->comment }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
  
@endsection
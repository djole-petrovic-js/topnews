@extends('layouts.admin')

@section('adminContent')
  <h1>Comments</h1>
  @if ( count($comments) == 0 )
    <div class="alert alert-info">
      <p>No comments at the moment!</p>
    </div>
  @else
    <table class="table table-hover">
      <thead>
        <tr>
          <td>No.</td>
          <td>Comment</td>
          <td>Posted by</td>
          <td>Story</td>
          <td>Date</td>
          <td>Delete</td>
        </tr>
      </thead>
      <tbody>
        @foreach ( $comments as $comment )
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $comment->comment }}</td>
            <td>{{ $comment->name }}</td>
            <td>{{ $comment->title }}</td>
            <td>{{ date('d/m/Y',strtotime($comment->created_at)) }}</td>
            <td>
              <form method="POST" action="{{ route('adminCommentsDestroy') }}">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $comment->commentID }}">
                <button class="btn btn-danger" type="submit">Delete</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
@endsection
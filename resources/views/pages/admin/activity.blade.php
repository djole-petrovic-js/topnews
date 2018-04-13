@extends('layouts.admin')

@section('adminContent')
  <h1>Users Activity</h1>

  @if ( count($activities) == 0 )
    <div class="alert alert-info">
      <p>No activities logged at the moment...</p>
    </div>
  @else
    <form method="POST" action="{{ route('adminActivityDestroyAll') }}">
      <h2>Delete All Activities!</h2>
      {{ csrf_field() }}
      <button type="submit" class="btn btn-danger">Delete</button>
    </form>
    <br/>
    <table class="table table-hover">
      <thead>
        <tr>
          <td>No.</td>
          <td>User</td>
          <td>Activity</td>
          <td>Date</td>
          <td>Delete</td>
        </tr>
      </thead>
      <tbody>
        @foreach ( $activities as $activity )
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $activity->name }}</td>
            <td>{{ $activity->content }}</td>
            <td>{{ date('d/m/Y H:i',strtotime($activity->created_at)) }}</td>
            <td>
              <form method="POST" action="{{ route('adminActivityDestroyOne') }}">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $activity->activityID }}">
                <button type="submit" class="btn btn-danger">Delete</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
@endsection
@extends('layouts.admin')

@section('adminContent')
  <div class="col-md-6">
    <h1>Polls</h1>
    <form method="POST" action="{{ route('adminPollsAdd') }}">
      {{ csrf_field() }}
      <h1>Add new Poll</h1>
      <div class="form-group">
        <input type="text" name="name" placeholder="Poll name" class="form-control">
      </div>
      <div id="options-wreaper" class="form-group">
        
      </div>
      <div id="options-wreaper" class="form-group">
        <span id="btnAddOption" class="btn btn-primary">Add new Option</span>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">Add!</button>
      </div>
    </form>
  </div>
  <div class="col-md-8">
    @if ( count($polls) == 0 )
      <div class="alert alert-info">
        <p>No polls at the moment.</p>
      </div>
    @else
      <ul class="list-group">
        @foreach ( $polls as $poll )
          <li class="list-group-item">
            <p>{{ $poll->polls_name }} votes : {{ $poll->number_of_votes }}</p>
            @foreach ( $options as $option )
              @if ( $option->poll_id == $poll->id )
                <p>{{ $option->option_name }} : {{ $option->votes }}</p>
              @endif
            @endforeach
            @if ( $poll->is_selected )
              <form method="POST" action="{{ route('adminPollInactive') }}">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $poll->id }}">
                <button class="btn btn-success">Make this poll inactive</button>
              </form>
            @else
              <form method="POST" action="{{ route('adminPollSelected') }}">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $poll->id }}">
                <button class="btn btn-primary">Make as Active Poll</button>
              </form>
            @endif
            <form method="POST" action="{{ route('adminPollsDestroy') }}">
              {{ csrf_field() }}
              <input type="hidden" name="id" value="{{ $poll->id }}">
              <button class="btn btn-danger" type="submit">Delete This Poll!</button>
            </form>
          </li>
        @endforeach
      </ul>
    @endif
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/admin/polls.js') }}"></script>
@endsection
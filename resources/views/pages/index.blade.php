@extends('layouts.main')

@section('title')
  Home
@endsection

@section('metadata')
  @include('inc.slider')
@endsection

@section('content')
  <div id="line">
    <div class="dline"></div>
      <div class="categories-wrapper">
        <ul class="list-inline">
          @foreach ( $categories as $categorie )
            <li class="list-inline-item">
              <a href="{{ route('search') . '/' . $categorie->categorie_name }}">{{ $categorie->categorie_name }}</a>
            </li>
          @endforeach
        </ul>
      </div>
    <div class="dline"></div>
  </div>
  <div class="row">
    <div class="col-md-7">
      <div id="ourserv">
        @foreach ( $stories as $story )
          <article>
            <h1>{{ $story->title }}</h1>
            <img src="{{ asset('uploads/' . $story->image) }}" alt="" />
            <p>{{ $story->description }}</p>
            <a href="{{ route('storiesRead',$story->id) }}">Read More</a>
          </article>
        @endforeach
      </div>
    </div>
    <div class="col-md-5">
      @if ( isset($poll) )
        <div class='panel panel-primary' id="poll" data-id="{{ $poll->id }}">
            <div class='panel-heading'>
              <h3 class='panel-title'><span class='fa fa-line-chart'></span>{{ $poll->polls_name }}</h3>
            </div>
            <div class='panel-body'>
              <ul class='list-group' id='pollUL'>
                @foreach ( $options as $option )
                  <li class='list-group-item'>
                    <div class='checkbox'>
                      <label>
                        <input name='poll' type='radio' value='{{ $option->id }}'> {{ $option->option_name }}
                      </label>
                    </div>
                  </li>
                @endforeach
              </ul>
            </div>
            <div class='panel-footer text-center' id="controls">
              @if ( Auth::check() )
                <button id='btnVote' type='button' class='btn btn-primary btn-block btn-sm'>
                  Vote!
                </button>
              @else
                <p>You have to logged in in order to vote!</p>
              @endif
              
              <button class='btn btn-primary btn-block btn-sm' id='btnShowVotes' class='small'>
                  Get results!
              </button>
            </div>
        </div>
      @endif
    </div>
  </div>
  
@endsection

@section('scripts')
  <script src="{{ asset('js/attempt.js') }}"></script>
  <script src="{{ asset('js/checkTypes.js') }}"></script>
  <script src="{{ asset('js/polls.js') }}"></script>
@endsection
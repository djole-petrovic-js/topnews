@extends('layouts.main')

@section('title')
  About
@endsection

@section('content')
  <h1>About Author</h1>

  <div class="row">
    <div class="col-md-6">
      <img class="img-responsive" src="{{ asset('images/Djordje-Petrovic.jpg') }}" id="img">
    </div>
    <div class="col-md-6">
      <p id="bio">Ja sam Djordje Petrovic. Rodjen sam u Pirotu, a zivim u Beogradu od 2010-e godine, i imam 24 godina. Trenutno studiram web programiranje na Visokoj ICT skoli u Beogradu. U slobodno vreme volim da gledam filmove , da igram poker, da izlazim itd itd...</p>
    </div>
  </div>
@endsection
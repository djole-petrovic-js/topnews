@extends('layouts.main')

@section('title')
	Admin Panel
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h1>Admin Panel</h1>
			@if ( $errors )
				<ul class="list-group">
					@foreach ( $errors->all() as $e)
						<div class="alert alert-danger">
							<p>{{ $e }}</p>
						</div>
					@endforeach
				</ul>
			@endif
			@if ( session('success') )
				<div class="alert alert-success">
					<p>{{ session('success') }}</p>
				</div>
			@endif
			@if ( session('error') )
				dd('macka');
				<div class="alert alert-danger">
					<p>{{ session('error') }}</p>
				</div>
			@endif
		</div>
	</div>
	<div class="row">
		<div class="col-md-2">
			<ul class="list-group">
				<li class="list-group-item">
					<a href="{{ route('adminShow') }}" class="">Welcome</a>
				</li>
					<li class="list-group-item">
					<a href="{{ route('adminUsers') }}">Users</a>
				</li>
				<li class="list-group-item">
					<a href="{{ route('adminLinks') }}" class="">Links</a>
				</li>
				<li class="list-group-item">
					<a href="{{ route('adminStories') }}" class="">Stories</a>
				</li>
				<li class="list-group-item">
					<a href="{{ route('adminParagraphs') }}">Paragraphs</a>
				</li>
				<li class="list-group-item">
					<a href="{{ route('adminCategories') }}" class="">Categories</a>
				</li>
				<li class="list-group-item">
					<a href="{{ route('adminGalery') }}">Galery Images</a>
				</li>
				<li class="list-group-item">
					<a href="{{ route('pollsShow') }}">Polls</a>
				</li>
				<li class="list-group-item">
					<a href="{{ route('adminComments') }}">Comments</a>
				</li>
				<li class="list-group-item">
					<a href="{{ route('adminSliderShow') }}">Slider</a>
				</li>
				<li class="list-group-item">
					<a href="{{ route('adminActivityShow') }}">Users Activity</a>
				</li>
			</ul>
		</div>
		<div class="col-md-10">
			@yield('adminContent')
		</div>
	</div>
@endsection

<div class="container">
	<header>
		<div id="logo">
		<h1><a href="{{ route('index') }}" id="logoLink">TOP NEWS</a> <span id="iisrt"><span id="ii">II</span><a href="{{ route('index') }}"><span id="srt">TN</span></a></span></h1>
		<div id="tagline">
			<h2>Just another news provider!</h2>
		</div>
		</div>
		<nav>
			<ul>
				@foreach ( $links as $link )
					<li><a href="{{ url($link->href) }}">{{ $link->name }}</a></li>
				@endforeach
				<li><a href="/dokumentacija.pdf">Documentation</a></li>
			</ul>
		</nav>
	</header>
</div>

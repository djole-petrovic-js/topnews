<footer>
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<ul class="list-inline" id="footerLinks">
					@foreach ( $links as $link )
						<li><a href="{{ url($link->href) }}">{{ $link->name }}</a></li>
					@endforeach
				</ul>
			</div>
			<div class="col-md-4">
				<p>Copyright &amp; copy TopNews. All Rights Reserved.</p>
			</div>
		</div>
	</div>
</footer>
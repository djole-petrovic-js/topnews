<div class="slider-wrapper theme-default">
	<div id="slider" class="nivoSlider">
		@foreach ($sliderImages as $image)
  		<img src="{{ asset('uploads/' . $image->path) }}" />
		@endforeach
	</div>
</div>
<script type="text/javascript">
$(window).load(function() {
	$('#slider').nivoSlider({pauseTime: 6000,});
});
</script>
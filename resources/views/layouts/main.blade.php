<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/nivo-slider.css') }}" type="text/css" media="screen" />
  <link rel="stylesheet" href="{{ asset('css/default/default.css') }}" type="text/css" media="screen" />
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
  <script src="js/jquery.nivo.slider.pack.js" type="text/javascript"></script>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
  <!-- <script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script> -->
  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  @yield('meta')
  <title>@yield('title')</title>
</head>
<body id="home">
  <div id="wrapper">
    @include('inc.nav')
    @yield('metadata')
      <div class="container" id="wrapper">
        @yield('content')
      </div>
    @include('inc.footer')
    @yield('scripts')
  </div>
</body>
</html>

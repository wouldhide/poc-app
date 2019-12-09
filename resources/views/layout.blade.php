<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>POC demo - @yield('title')</title>

  <link href="/css/bootstrap.min.css" rel="stylesheet">

</head>

<body style="background: #e6e6e6">

  <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
        <div class="container">
            <a class="navbar-brand" href="#">POC demo movie app</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item {{ \Request::route()->getName() == 'home' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item {{ \Request::route()->getName() == 'movies' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('movies') }}">Movie list</a>
                    </li>
                    <li class="nav-item {{ \Request::route()->getName() == 'imdb' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('imdb') }}">IMDB search</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="/js/jquery.slim.min.js"></script>
    <script src="/js/bootstrap.bundle.min.js"></script>

</body>

</html>
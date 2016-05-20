<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title') @if (View::hasSection('title'))|@endif Service Discovery with Consul</title>

    <!-- Styles -->
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">
</head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="/">Service Discovery with Consul</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
              <ul class="nav navbar-nav">
                <li class="active"><a href="/">Home</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Demos <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="/demos/dns">DNS</a></li>
                    <li><a href="/demos/api">HTTP API</a></li>
                    <li><a href="/demos/kv">Key / Value Storage</a></li>
                    <li><a href="/demos/locks">Locks</a></li>
                  </ul>
                </li>
              </ul>
            </div><!--/.nav-collapse -->
          </div>
        </nav>

        @yield('page')
        @stack('scripts')

        <!-- <footer>
        <p>&copy; Chris Stevens</p>
        </footer> -->

        <script src="{{ elixir('js/app.js') }}"></script>
    </body>
</html>

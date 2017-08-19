<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{-- config('app.name', 'Laravel') --}} S.G.F.P</title>

    <!-- Styles -->
    <link href="{{ env('APP_URL') }}/css/app.css" rel="stylesheet">
    <link href="{{ env('APP_URL') }}/css/estilo.css" rel="stylesheet">
    <link href="{{ env('APP_URL') }}/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="{{env('APP_URL') }}/js/jquery3-11.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/home') }}">
                        {{-- config('app.name', 'Laravel') --}}  S.G.F.P
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Entrar</a></li>
                            <li><a href="{{ url('/register') }}">Registrar</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Sair
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        @yield('content')
    </div>
    <footer class="footer">
      <div class="container">
        <p class="text-muted">&copy Dyego B. S. Donadone - 2016 - Sistema de Gerenciamento Financeiro Pessoal</p>
      </div>
    </footer>
    <!-- Scripts -->
    <script src="{{env('APP_URL') }}/js/app.js"></script>
    <script type="text/javascript">
        $(window).width();
        if (window.screen.availWidth <= 600){
           $( ".ul_submenu" ).hide();
        }
    </script>
    <script src="{{env('APP_URL') }}/js/jquery.dataTables.min.js"></script>
</body>
</html>

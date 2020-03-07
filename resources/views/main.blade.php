<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ url('../resources/css/fontawesome-free/css/all.min.css') }}">
     <link rel="stylesheet" href="{{ url('../resources/css/custom.css') }}">

    <title>Adopt-A-School Project</title>
  </head>
  <body>
    <img src="{{ url('img/banner.png') }}" width="100%" height="100%" />
    <nav class="navbar navbar-expand-md navbar-dark bg-dark py-0" style="margin-top: -0.12%;">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">


          @auth('stakeholders')

            @if(Request::is('account/stakeholders')) <li class="nav-item active"> @else <li class="nav-item"> @endif
              <a href="{{ url('/account/stakeholders') }}" class="nav-link">Dashboard</a>
            </li>
          
             @if(Request::is('account/stakeholders/projects') || Request::is('account/stakeholders/projects/filtered')) <li class="nav-item active"> @else <li class="nav-item"> @endif
              <a href="{{ url('account/stakeholders/projects') }}" class="nav-link">Projects</a>
            </li>

            @if(Request::is('account/stakeholders/contributions')) <li class="nav-item active"> @else <li class="nav-item"> @endif
              <a href="{{ url('account/stakeholders/contributions') }}" class="nav-link">Contributions</a>
            </li>

          @endauth

          @auth('schools')

            @if(Request::is('account/schools')) <li class="nav-item active"> @else <li class="nav-item"> @endif
              <a href="{{ url('/account/schools') }}" class="nav-link">Dashboard</a>
            </li>
          
            @if(Request::is('account/schools/projects') || Request::is('account/schools/projects/filtered')) 
              <li class="nav-item active"> 
            @else 
              <li class="nav-item"> 
            @endif
              <a href="{{ url('/account/schools/projects') }}" class="nav-link">Projects</a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link">Stakeholders</a>
            </li>            
          @endauth

          @if(Auth::guard('stakeholders')->guest() && Auth::guard('schools')->guest())
            @if(Request::is('home')) <li class="nav-item active"> @else <li class="nav-item"> @endif
                <a class="nav-link" href="{{ url('/home') }}">Home</a>
              </li>
            @if(Request::is('projects') || Request::is('projects/filtered')) <li class="nav-item active"> @else <li class="nav-item"> @endif
              <a class="nav-link" href="{{ url('/projects') }}">Projects</a>
            </li>              
            <li class="nav-item">
              <a class="nav-link" href="#">Schools</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact us</a>
            </li>
          @endif
        </ul>

        <ul class="navbar-nav">

          @if(Auth::guard('stakeholders')->guest() && Auth::guard('schools')->guest())
            @if(Request::is('stakeholders/registration') || Request::is('school/registration'))
              <li class="nav-item dropdown active">
            @else
              <li class="nav-item dropdown">
            @endif
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Register</a>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{ url('/stakeholders/registration') }}">as Stakeholders</a>
                  <a class="dropdown-item" href="{{ url('/school/registration') }}">as School</a>
                </div>
              </li>

            @if(Request::is('login')) <li class="nav-item active"> @else <li class="nav-item"> @endif
              <a class="nav-link" href="{{ url('/login') }}">Login</a>
            </li>  
          @endif

          @auth('stakeholders')
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Stakeholders</a>
              <div class="dropdown-menu">
                <a href="#" class="dropdown-item">Profile</a>
                <a href="{{ url('account/stakeholders/logout') }}" class="dropdown-item">Logout</a>
              </div>
            </li>
          @endauth

          @auth('schools')
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">School</a>
              <div class="dropdown-menu">
                <a href="#" class="dropdown-item">Profile</a>
                <a href="{{ url('account/schools/logout') }}" class="dropdown-item">Logout</a>
              </div>
            </li>
          @endauth

        </ul>
      </div>
    </nav>

    @yield('home')
    @yield('stakeholders-registration')
    @yield('school-registration')
    @yield('login')

    <!--secured pages-->  
    @yield('stakeholders-dashboard')
    @yield('stakeholders-projects')
    @yield('stakeholders-contributions')

    @yield('schools-dashboard')
    @yield('schools-projects')

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    @stack('home-scripts')
    @stack('stakeholders-registration-scripts')
    @stack('school-registration-scripts')
    @stack('login.js')

    @stack('stakeholders-projects-scripts')
    @stack('stakeholders-contributions-scripts')

    @stack('schools-projects-scripts')
  </body>
</html>    
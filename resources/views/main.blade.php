<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ url('../resources/library/bootstrap4.4.1/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('../resources/library/jquery-ui1.12.1/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ url('../resources/css/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ url('../resources/css/custom.css') }}">

    <title>Adopt-A-School Project</title>
  </head>
  <body>
    <img src="{{ url('img/banner.png') }}" class="img-fluid" />
    <nav class="navbar navbar-expand-md navbar-dark bg-dark py-0" style="margin-top: -0.12%;">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">

          <!-----ADMIN MENU-------->
          @auth('admin')
            @if(Request::is('account/admin')) <li class="nav-item active"> @else <li class="nav-item"> @endif
              <a href="{{ url('/account/admin') }}" class="nav-link">Dashboard</a>
            </li>          

            @if(Request::is('account/admin/request')) <li class="nav-item active"> @else <li class="nav-item"> @endif
              <a href="{{ url('/account/admin/request') }}" class="nav-link">Request</a>
            </li>  
          @endauth
          
          <!----STAKEHOLDERS MENU----->
          @auth('stakeholders')

            @if(Request::is('account/stakeholders')) <li class="nav-item active"> @else <li class="nav-item"> @endif
              <a href="{{ url('/account/stakeholders') }}" class="nav-link">Dashboard</a>
            </li>
          
             @if(Request::is('account/stakeholders/projects') || Request::is('account/stakeholders/projects/filtered') || Request::is('project/*')) 
              <li class="nav-item active"> 
             @else 
              <li class="nav-item"> 
             @endif
              <a href="{{ url('account/stakeholders/projects') }}" class="nav-link">Projects</a>
            </li>

            @if(Request::is('account/stakeholders/contributions') || Request::is('account/stakeholders/contributions/filtered')) 
              <li class="nav-item active"> 
            @else 
              <li class="nav-item"> 
            @endif
              <a href="{{ url('account/stakeholders/contributions') }}" class="nav-link">Contributions</a>
            </li>

          @endauth

          <!---SCHOOLS MENU--->
          @auth('schools')

            @if(Request::is('account/schools')) <li class="nav-item active"> @else <li class="nav-item"> @endif
              <a href="{{ url('/account/schools') }}" class="nav-link">Dashboard</a>
            </li>
          
            @if(Request::is('account/schools/projects') || Request::is('account/schools/projects/filtered') || Request::is('project/*')) 
              <li class="nav-item active"> 
            @else 
              <li class="nav-item"> 
            @endif
              <a href="{{ url('/account/schools/projects') }}" class="nav-link">Projects</a>
            </li>

            @if(Request::is('account/schools/stakeholders'))  <li class="nav-item active"> @else <li class="nav-item"> @endif
              <a href="{{ url('/account/schools/stakeholders') }}" class="nav-link">Stakeholders</a>
            </li>            
          @endauth


          <!-----GUEST MENU---->
          @if(Auth::guard('stakeholders')->guest() && Auth::guard('schools')->guest() && Auth::guard('admin')->guest())
            @if(Request::is('home')) <li class="nav-item active"> @else <li class="nav-item"> @endif
                <a class="nav-link" href="{{ url('/home') }}">Home</a>
              </li>

            @if(Request::is('projects') || Request::is('projects/filtered') || Request::is('project/*')) 
              <li class="nav-item active"> 
            @else 
              <li class="nav-item"> 
            @endif
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

          @if(Auth::guard('stakeholders')->guest() && Auth::guard('schools')->guest() && Auth::guard('admin')->guest())
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

          @auth('admin')
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Admin</a>
              <div class="dropdown-menu">
                <a href="#" class="dropdown-item">Profile</a>
                <a href="{{ url('account/admin/logout') }}" class="dropdown-item">Logout</a>
              </div>
            </li>
          @endauth

          @auth('stakeholders')
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Stakeholders</a>
              <div class="dropdown-menu">
                <a href="{{ url('account/stakeholders/profile') }}" class="dropdown-item">Profile</a>
                <a href="{{ url('account/stakeholders/logout') }}" class="dropdown-item">Logout</a>
              </div>
            </li>
          @endauth

          @auth('schools')
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">School</a>
              <div class="dropdown-menu">
                <a href="{{ url('account/schools/profile') }}" class="dropdown-item">Profile</a>
                <a href="{{ url('account/schools/logout') }}" class="dropdown-item">Logout</a>
              </div>
            </li>
          @endauth

        </ul>
      </div>
    </nav>

    @yield('home')
    @yield('single-project')
    @yield('admin-registration')
    @yield('stakeholders-registration')
    @yield('school-registration')
    @yield('login')

    <!--guest---->
    @yield('guest-projects')

    <!--secured pages-->  
    @yield('admin-dashboard')
    @yield('admin-request')

    @yield('stakeholders-dashboard')
    @yield('stakeholders-projects')
    @yield('stakeholders-contributions')
    @yield('stakeholders-profile')

    @yield('schools-dashboard')
    @yield('schools-projects')
    @yield('schools-stakeholders')
    @yield('schools-profile')

    <script src="{{ url('../resources/js/jquery1.12.4/jquery.js') }}"></script>
    <script src="{{ url('../resources/js/popper.min.js') }}"></script>
    <script src="{{ url('../resources/library/bootstrap4.4.1/bootstrap.min.js') }}"></script>
    <script src="{{ url('../resources/library/jquery-ui1.12.1/jquery-ui.js') }}"></script>
    
    @stack('home-scripts')
    @stack('single-project-scripts')
    @stack('admin-registration-scripts')
    @stack('stakeholders-registration-scripts')
    @stack('school-registration-scripts')
    @stack('guest-projects-scripts')
    @stack('login.js')

    @stack('admin-request-scripts')
    @stack('stakeholders-projects-scripts')
    @stack('stakeholders-contributions-scripts')
    @stack('stakeholders-profile-scripts')

    @stack('schools-dashboard-scripts')
    @stack('schools-projects-scripts')
    @stack('schools-stakeholders-scripts')
    @stack('schools-profile-scripts')
  </body>
</html>    
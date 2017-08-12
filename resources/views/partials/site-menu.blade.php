<nav class="nav fixed-top navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="/">Canopy Story</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav justify-content-end">
        <li class="nav-item">
            <a class="nav-link" href="/">Tell Story</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('post') }}">Find Stories</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('about') }}">About Us</a>
        </li>
      </ul>
      <ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
        <li class="nav-item">
            @if(\App::getLocale() === 'en')
            <a href="?lang=es" class="btn btn-light btn-sm">
              <span class="text-muted"><span class="lang-sm lang-lbl" lang="es"></span></span>
            </a>
            @else
            <a href="?lang=en" class="btn btn-light btn-sm">
              <span class="text-muted"><span class="lang-sm lang-lbl" lang="en"></span></span>
            </a>
            @endif
        </li>
        <li class="nav-item">
            @if(Auth::check())
            <a class="btn btn-primary btn-sm" role="button" href="{{ url('logout') }}">
              <span class='glyphicon glyphicon-user'></span> Logout
            </a>
            @else
            <a class="btn btn-primary btn-sm  my-2 my-sm-0" role="button" href="{{ url('login') }}">
              <span class='glyphicon glyphicon-user'></span> Login
            </a>
            @endif
        </li>
      </ul>
    </div>

</nav>

<nav class="nav fixed-top navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="{{route('index')}}">Canopy Story</a>

    <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav justify-content-end">
        <li class="nav-item">
            <a class="nav-link" href="/">@lang('menu.tell_story')</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('post') }}">@lang('menu.find_stories')</a>
        </li>
        <!--li class="nav-item">
            <a class="nav-link" href="{{ route('about') }}">@lang('menu.about_us')</a>
        </li-->
      </ul>
      <div class="d-flex flex-row ml-auto mr-auto logo-container">
        <div class="pr-2" style="border-right: 1px solid #eee">
          <a href="https://www.pdx.edu/sustainability/iss" 
              title="Portland State University Institute for Sustainable Solutions">
            <div id="psu-iss-logo">
            </div>
          </a>
        </div>
        <div class="ml-2 mr-2">
        <a href="https://www.fs.fed.us/" title="U.S. Forest Service">
          <div id="fs-logo">
          </div>
        </a>
      </div>
    </div>
    @if(isset($is_map))
    <!--form class="form-inline ml-md-auto mr-5 my-lg-0">
      <input class="form-control " type="text" placeholder="@lang('menu.search_bar')" 
        aria-label="Search" style="width: 250px">
    </form-->
      <ul class="navbar-nav flex-row d-none d-md-flex">
    @else
      <ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
    @endif
        <li class="nav-item mr-2">
            <form method="post" action="{{url('language')}}" style="margin: 0">
                {{ csrf_field() }}
                @if(\App::getLocale() === 'en')
                <input type="hidden" name="lang" value="es" />
                <button type="submit" class="btn btn-light btn-sm" >
                    Español
                </button>
                @else
                <input type="hidden" name="lang" value="en" />
                <button type="submit" class="btn btn-light btn-sm" >
                    English
                </button>
                @endif
            </form>
        </li>
        <li class="nav-item">
            @if(Auth::check())
            <div class="dropdown show">
              <a class="text-white mr-2 ml-2" style="padding: 5px" href="#" role="button" 
                    id="dropdownMenuLink" data-toggle="dropdown" 
                    aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-bars fa-lg"></i>
              </a>

              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                @if((Auth::user()->isAdmin()))
                <a class="dropdown-item" role="button" href="{{ route('admin') }}">
                  <span class='glyphicon glyphicon-user'></span> Admin
                </a>
                <hr class="mt-0 mb-1" />
                @endif
                <a class="dropdown-item" href="{{ route('user.profile', ['id' => Auth::user()->id]) }}">
                    @lang('site.profile')
                </a>
                <a class="dropdown-item" role="button" href="{{ route('logout') }}">
                  <span class='glyphicon glyphicon-user'></span> @lang('site.logout')
                </a>
              </div>
            </div>
            @else
            <a class="btn btn-primary btn-sm  my-2 my-sm-0" role="button" href="{{ url('login') }}">
              <span class='glyphicon glyphicon-user'></span> @lang('site.login')
            </a>
            @endif
        </li>
      </ul>
    </div>

</nav>

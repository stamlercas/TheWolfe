<header>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
              <a class="navbar-brand" href="{{ route('dashboard') }}">Selfie's of Codey Wolfe<sub> Beta</sub></a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                @if(Auth::check())
                <li><a href="{{ route('account') }}">Account</a></li>
                <li><a href="{{ route('logout') }}">Logout, {{ Auth::user()->username }}</a></li>
                @else
                <li><a href="{{ route('home') }}">Login</a></li>
                @endif
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </nav>
</header>
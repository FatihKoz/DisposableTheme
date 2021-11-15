<nav id="Dispo_SideBar" class="navbar navbar-start navbar-light bg-transparent mt-0 pt-0">
  <div class="container-fluid">
    <a class="navbar-brand my-0" href="/">
      <img class="img-mh30" src="{{ public_asset('/disposable/theme_logo.png') }}"/>
    </a>
    @if(Theme::getSetting('gen_utc_clock'))
      <div id="clock" class="btn btn-outline-dark ms-auto mx-1 px-1 py-0" style="pointer-events: none">
        <i class="fas fa-clock me-1"></i>
        <span id="utc_clock" class="me-1"></span>
      </div>
    @endif
    <button class="navbar-toggler border-0 shadow-none text-black" type="button" data-bs-toggle="offcanvas" data-bs-target="#SideBar" aria-controls="SideBar" aria-expanded="false" aria-label="Toggle Main Menu">
      <i class="fas fa-compass" title="Toggle Main Menu"></i>
    </button>
    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="SideBar" aria-labelledby="SideBarLabel">
      <div class="offcanvas-header px-2 py-1">
        <h5 class="offcanvas-title" id="SideBarLabel">
          <a href="/"><img class="img-mh20" src="{{ public_asset('/disposable/theme_logo.png') }}"/></a>
        </h5>
        <button type="button" class="btn-close btn-small text-reset me-1 shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          @include('nav_menu')
        </ul>
      </div>
    </div>
  </div>
</nav>
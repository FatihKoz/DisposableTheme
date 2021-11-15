<nav id="Dispo_NavBar" class="navbar navbar-expand-lg mt-0 pt-0 pb-1">
  <div class="container-fluid">
    <a class="navbar-brand my-0" href="/">
      <img class="img-mh30" src="{{ public_asset('/disposable/theme_logo.png') }}"/>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle Main Menu">
      <i class="fas fa-compass" title="Main Menu"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <div class="navbar-nav ms-auto">
        @include('nav_menu')
      </div>
    </div>
  </div>
</nav>
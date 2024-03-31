@extends('app')
@section('title', __('home.welcome.title'))
@if(Theme::getSetting('home_disable') && !Auth::check())
  <script type="text/javascript">
    window.location = "{{ url('/login') }}";
  </script>
@endif
@include('theme_helpers')
@php
  $DBasic = check_module('DisposableBasic');
@endphp
@section('content')
  {{-- Top Row --}}
  <div class="row row-cols-lg-3 mb-1">
    <div class="col-lg-2">
      @if(Theme::getSetting('home_ivao_logo'))
        <div class="card col-lg-7 shadow-none bg-transparent border-0 my-3 float-start">
          <a href="https://www.ivao.aero" target="_blank">
            @if(filled(Theme::getSetting('gen_ivao_vaid')))
              <img class="card-img" src="{{ public_asset('disposable/logo_ivao_partner.svg') }}">
            @else
              <img class="card-img" src="{{ public_asset('disposable/logo_ivao_main.png') }}">
            @endif
          </a>
        </div>
      @endif
    </div>
    {{-- Center --}}
    <div class="col-lg-8">
      @if(Theme::getSetting('home_carousel'))
        {{-- Carousel --}}
        @php $images = DT_GetImages('image/slide/'); @endphp
        @if($images)
          <div class="card mb-2">
            <div id="DT_HomeSlide" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                @foreach ($images as $image)
                  <div class="carousel-item @if($loop->first) active @endif">
                    <img src="{{ $image }}" class="d-block w-100 rounded">
                  </div>
                @endforeach
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#DT_HomeSlide" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#DT_HomeSlide" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
          </div>
        @endif
        {{-- End Carousel --}}
      @endif
    </div>
    <div class="col-lg-2">
      @if(Theme::getSetting('home_vatsim_logo'))
        <div class="card col-lg-7 shadow-none bg-transparent border-0 my-3 float-end">
          <a href="https://www.vatsim.net" target="_blank">
            <img class="card-img" src=" {{ public_asset('disposable/logo_vatsim.png') }}">
          </a>
        </div>
      @endif
    </div>
  </div>
  {{-- Another row for possible widgets and fixed content --}}
  <div class="row row-cols-xl-4">
    <div class="col-lg">
      {{-- Latest Pilots --}}
      <div class="card mb-2">
        <div class="card-header p-1">
          <h5 class="m-1">
            @lang('common.newestpilots')
            <i class="fas fa-users float-end"></i>
          </h5>
        </div>
      </div>
      @foreach($users as $user)
        <div class="card mb-2">
          <div class="row g-0">
            <div class="col-3">
              @if (isset($user->avatar))
                <img class="img-fluid rounded-start border-end border-dark img-mh80" src="{{ $user->avatar->url }}" alt="">
              @else
                <img class="img-fluid rounded-start border-end border-dark img-mh80" src="{{ $user->gravatar(100) }}" alt="">
              @endif
            </div>
            <div class="col-9">
              <div class="card-body p-1">
                <h5 class="card-title m-0">
                  <a href="{{ route('frontend.profile.show', [$user->id]) }}">{{ $user->name_private }}</a>
                </h5>
                <p class="card-text m-0">{{ optional($user->home_airport)->name }}</p>
                <span class="card-text m-0 small text-muted">{{ $user->created_at->diffForHumans() }}</span>
              </div>
            </div>
          </div>
        </div>
      @endforeach
      {{-- End Latest Pilots --}}
    </div>
    @if($DBasic)
      <div class="col-lg">
        @widget('DBasic::LeaderBoard', ['source' => 'pilot', 'period' => 'lastm', 'count' => 1, 'type' => 'flights'])
      </div>
      <div class="col-lg">
        @widget('DBasic::LeaderBoard', ['source' => 'pilot', 'period' => 'lastm', 'count' => 1, 'type' => 'time'])
      </div>
      <div class="col-lg">
        @widget('DBasic::Stats', ['type' => 'home'])
      </div>
    @endif
  </div>
@endsection

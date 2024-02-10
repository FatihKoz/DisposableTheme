@extends('app', ['disable_nav' => true])
@section('title', __('common.login'))

@section('content')
  @if(Theme::getSetting('login_logo'))
    <div class="clearfix" style="height: 2vh;"></div>
  @else
    <div class="clearfix" style="height: 30vh;"></div>
  @endif
  <div class="row mt-2">
    <div class="col-lg-4 mx-auto content-center">
      <form class="form" method="post" action="{{ url('/login') }}">
        @csrf
        <div class="card">
          @if(Theme::getSetting('login_logo'))
            <img class="card-img-top" src="{{ public_asset('/disposable/theme_logo_big.png') }}">
          @endif
          <div class="card-body p-1">
            @if($errors->any())
              {!! implode('', $errors->all('<div class="alert alert-danger mb-1 p-1 px-2 fw-bold">:message</div>')) !!}
            @endif
            <div class="input-group input-group-sm mb-2">
              <span class="input-group-text" id="email"><i class="fas fa-user"></i></span>
              <input
                class="form-control" type="text" name="email" aria-label="email" aria-describedby="email"
                placeholder="{{ __('common.email').' '.__('common.or').' '.__('common.pilot_id') }}" required>
            </div>
            <div class="input-group input-group-sm mb-2">
              <span class="input-group-text" id="password"><i class="fas fa-key"></i></span>
              <input
                class="form-control" type="password" name="password" aria-label="password" aria-describedby="password"
                placeholder="{{ __('auth.password') }}" required>
            </div>
          </div>
          <div class="card-footer p-1 text-center d-grid">
            <div class="row">
              @if(config('services.discord.enabled'))
                <div class="col d-grid">
                  <a href="{{ route('oauth.redirect', ['provider' => 'discord']) }}" class="btn btn-primary btn-sm">
                    <i class="fab fa-discord mx-1"></i>
                    @lang('auth.loginwith', ['provider' => 'Discord'])
                  </a>
                </div>
              @endif
              <div class="col d-grid">
                <button class="btn btn-primary btn-sm">
                  <i class="fas fa-sign-in-alt mx-1"></i>
                  @lang('common.login')
                </button>
              </div>
            </div>
          </div>
          <div class="card-footer p-1 text-end">
            <span class="float-start"><a href="{{ url('/register') }}">@lang('auth.createaccount')</a></span>
            <span class="float-end"><a href="{{ url('/password/reset') }}">@lang('auth.forgotpassword')?</a></span>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

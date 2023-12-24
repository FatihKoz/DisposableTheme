@extends('app')
@section('title', __('auth.register'))
@php
  $only_hubs = ($hubs_only === true) ? 'hubs_only' : null;
@endphp
@section('content')
  <div class="row mt-2">
    <div class="col-lg-6 mx-auto content-center">
      {{ Form::open(['url' => '/register', 'class' => 'form-control bg-transparent border-0']) }}
        <div class="card mb-2">
          <div class="card-header p-1">
            <h5 class="m-1">
              @lang('common.register')
              <i class="fas fa-user-plus float-end"></i>
            </h5>
          </div>
          {{-- Form Fields --}}
          <div class="card-body p-1">
            <div class="input-group input-group-sm mb-1">
              <span class="input-group-text col-lg-3" id="name">@lang('auth.fullname')</span>
              <input class="form-control" type="text" name="name" aria-label="name" aria-describedby="name">
            </div>

            <div class="input-group input-group-sm mb-1">
              <span class="input-group-text col-lg-3" id="email">@lang('auth.emailaddress')</span>
              <input class="form-control" type="email" name="email" aria-label="email" aria-describedby="email">
            </div>

            <div class="input-group input-group-sm mb-1">
              <span class="input-group-text col-lg-3" id="airline_id">@lang('common.airline')</span>
              {{ Form::select('airline_id', $airlines, null, ['class' => 'form-control select2']) }}
            </div>

            <div class="input-group input-group-sm mb-1">
              <span class="input-group-text col-lg-3" id="home_airport_id">@lang('airports.home')</span>
              {{ Form::select('home_airport_id', [], null , ['class' => 'form-control '.$only_hubs.' airport_search']) }}
            </div>

            <div class="input-group input-group-sm mb-1">
              <span class="input-group-text col-lg-3" id="country">@lang('common.country')</span>
              {{ Form::select('country', $countries, null, ['class' => 'form-control select2']) }}
            </div>

            <div class="input-group input-group-sm mb-1">
              <span class="input-group-text col-lg-3" id="time_zone">@lang('common.timezone')</span>
              {{ Form::select('timezone', $timezones, null, ['id'=>'timezone', 'class' => 'form-control select2']) }}
            </div>

            @if(setting('pilots.allow_transfer_hours') === true)
              <div class="input-group input-group-sm mb-1">
                <span class="input-group-text col-lg-3" id="transfer_time">@lang('auth.transferhours')</span>
                {{ Form::number('transfer_time', 0, ['class' => 'form-control']) }}
              </div>
            @endif

            <div class="input-group input-group-sm mb-1">
              <span class="input-group-text col-lg-3" id="password">@lang('auth.password')</span>
              {{ Form::password('password', ['class' => 'form-control']) }}
            </div>

            <div class="input-group input-group-sm mb-1">
              <span class="input-group-text col-lg-3" id="password_confirmation">@lang('passwords.confirm')</span>
              {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
            </div>

            @if($userFields)
              @foreach($userFields as $field)
                <div class="input-group input-group-sm mb-1">
                  <span class="input-group-text col-lg-3" id="field_{{ $field->slug }}">
                    {{ $field->name }}
                    @if(filled($field->description))
                      <i class="fas fa-info-circle text-primary mx-2" title="{{ $field->description }}"></i>
                    @endif
                  </span>
                  @if(in_array(strtoupper($field->name), ['IVAO', 'IVAO ID', 'IVAO CID', 'VATSIM', 'VATSIM ID', 'VATSIM CID']))
                    {{ Form::number('field_'.$field->slug, null, ['class' => 'form-control', 'autocomplete' => 'off']) }}
                  @else
                    {{ Form::text('field_'.$field->slug, null, ['class' => 'form-control', 'autocomplete' => 'off']) }}
                  @endif
                </div>
              @endforeach
            @endif
          </div>
          {{-- Validation Responses --}}
          @if($errors->any())
            <div class="card-footer p-1">
              {!! implode('', $errors->all('<div class="alert alert-danger mb-1 p-1 px-2 fw-bold">:message</div>')) !!}
            </div>
          @endif
          {{-- Captcha --}}
          @if($captcha['enabled'] === true)
            <div class="card-footer p-1">
              <div class="input-group input-group-sm mb-1">
                <span class="input-group-text col-lg-3 mb-2">@lang('auth.fillcaptcha')</span>
                <span class="h-captcha" data-sitekey="{{ $captcha['site_key'] }}"></span>
              </div>
            </div>
          @endif

          <div class="card-footer p-1">
            @include('auth.toc')
          </div>

          <div class="card-footer p-0 table-responsive">
            <table class="table table-sm table-borderless align-middle mb-0">
              <tr>
                <td>
                  <div class="input-group ms-2">
                    {{ Form::hidden('toc_accepted', 0, false) }}
                    {{ Form::checkbox('toc_accepted', 1, null, ['id' => 'toc_accepted']) }}
                  </div>
                </td>
                <td>
                  <label for="toc_accepted" class="control-label">@lang('auth.tocaccept')</label>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="input-group ms-2">
                    {{ Form::hidden('opt_in', 0, false) }}
                    {{ Form::checkbox('opt_in', 1, null) }}
                  </div>
                </td>
                <td>
                  <label for="opt_in" class="control-label">@lang('profile.opt-in-descrip')</label>
                </td>
              </tr>
            </table>
          </div>

          <div class="card-footer p-1 d-grid">
            <div class="row">
              @if(config('services.discord.enabled'))
                <div class="col d-grid">
                  <a href="{{ route('oauth.redirect', ['provider' => 'discord']) }}" id="discord_button" class="btn btn-primary btn-sm disabled">
                    <i class="fab fa-discord mx-1"></i>
                    @lang('auth.loginwith', ['provider' => 'Discord'])
                  </a>
                </div>
              @endif
              <div class="col d-grid">
                {{ Form::submit(__('auth.register'), ['id' => 'register_button', 'class' => 'btn btn-primary btn-sm', 'disabled' => true]) }}
              </div>
            </div>
          </div>
        </div>
      {{ Form::close() }}
    </div>
  </div>
@endsection

@section('scripts')
  @parent
  @if($captcha['enabled'])
    <script src="https://hcaptcha.com/1/api.js" async defer></script>
  @endif
  <script>
    $('#toc_accepted').click(function () {
      if ($(this).is(':checked')) {
        console.log('toc accepted');
        $('#register_button').removeAttr('disabled');
        $('#discord_button').removeClass('disabled');
      } else {
        console.log('toc not accepted');
        $('#register_button').attr('disabled', 'true');
        $('#discord_button').addClass('disabled');
      }
    });
  </script>

  @include('scripts.airport_search')
@endsection

@php
  $disable_hub = (Theme::getSetting('user_disable_hub')) ? 'disabled' : null;
  $disable_airline = (Theme::getSetting('user_disable_airline')) ? 'disabled' : null;
  $only_hubs = ($hubs_only === true) ? 'hubs_only' : null;
@endphp
<div class="form-group">
  <div class="input-group input-group-sm">
    <span class="input-group-text col-md-3">{{ __('common.name') }}</span>
    <input class="form-control" type="text" name="name" id="name" value="{{ $user->name }}" />
  </div>
  <div class="input-group input-group-sm">
    <span class="input-group-text col-md-3">{{ __('common.email') }}</span>
    <input class="form-control" type="email" name="email" id="email" value="{{ $user->email }}" />
  </div>
  <div class="input-group input-group-sm">
    <span class="input-group-text col-md-3">Discord ID</span>
    <input class="form-control" type="text" name="discord_id" id="discord_id" value="{{ $user->discord_id }}" readonly />
    @if(config('services.discord.enabled') == true && blank($user->discord_id))
      <span class="input-group-text col-md-3">
        <a href="{{ route('oauth.redirect', ['provider' => 'discord']) }}">Link Discord Account</a>
      </span>
    @elseif(config('services.discord.enabled') == true && filled($user->discord_id))
      <span class="input-group-text col-md-3">
        <a href="{{ route('oauth.logout', ['provider' => 'discord']) }}">Unlink Discord Account</a>
      </span>
    @endif
  </div>
  <div class="input-group input-group-sm mb-3">
    <span class="input-group-text col-md-3">
      {{ __('profile.avatar') }}
      <i class="fas fa-info-circle text-primary mt-1 mx-2" title="{{ __('profile.avatarresize', ['width' => config('phpvms.avatar.width'), 'height' => config('phpvms.avatar.height')]) }}"></i>
    </span>
    <input class="form-control" type="file" name="avatar" id="avatar" />
    @if(filled($user->avatar))
      <span class="input-group-text HoverImage">
          <a href="#" title="Current Avatar">
            <img class="img-fluid rounded border border-dark img-mh100" src="{{ $user->avatar->url }}">
          </a>
          Current Avatar
      </span>
    @endif
  </div>
  <div class="input-group input-group-sm">
    <span class="input-group-text col-md-3">{{ __('common.timezone') }}</span>
    <select class="form-control select2" name="timezone" id="timezone">
      @foreach($timezones as $group_name => $group_timezones)
        <optgroup label="{{ $group_name }}">
          @foreach($group_timezones as $timezone_id => $timezone_label)
            <option value="{{ $timezone_id }}" @if($timezone_id == $user->timezone) selected @endif>{{ $timezone_label }}</option>
          @endforeach
        </optgroup>
      @endforeach
    </select>
  </div>
  <div class="input-group input-group-sm mb-3">
    <div class="input-group-text col-md-3">{{ __('common.country') }}</div>
    <select class="form-control select2" name="country" id="country">
      @foreach($countries as $country_id => $country_label)
        <option value="{{ $country_id }}" @if($user->country == $country_id) selected @endif>{{ $country_label }}</option>
      @endforeach
    </select>
  </div>
  <div class="input-group input-group-sm">
    <span class="input-group-text col-md-3">{{ __('airports.home') }}</span>
    <input type="hidden" name="home_airport_id" value="{{ $user->home_airport_id }}" />
    <select class="form-control airport_search {{ $only_hubs }}" name="home_airport_id" id="home_airport_id" {{ $disable_hub }}>
      @foreach($airports as $airport_id => $airport_label)
        <option value="{{ $airport_id }}">{{ $airport_label }}</option>
      @endforeach
    </select>
  </div>
  <div class="input-group input-group-sm mb-3">
    <span class="input-group-text col-md-3">{{ __('common.airline') }}</span>
    <input type="hidden" name="airline_id" value="{{ $user->airline_id }}" />
    <select class="form-control select2" name="airline_id" id="airline_id" {{ $disable_airline }}>
      @foreach($airlines as $airline_id => $airline_label)
        <option value="{{ $airline_id }}" @if($user->airline_id === $airline_id) selected @endif>{{ $airline_label }}</option>
      @endforeach
    </select>
  </div>
  {{-- Custom fields --}}
  @foreach($userFields as $field)
    <div class="input-group input-group-sm">
      <span class="input-group-text col-md-3">
        {{ $field->name }}
        @if($field->required === true)
          <span class="mx-2 text-danger fw-bold">*</span>
        @endif
        @if(filled($field->description))
          <i class="fas fa-info-circle text-primary mx-2" title="{{ $field->description }}"></i>
        @endif
      </span>
      @if(in_array(strtoupper($field->name), ['IVAO', 'IVAO ID', 'IVAO CID', 'VATSIM', 'VATSIM ID', 'VATSIM CID']))
        <input class="form-control" type="number" name="field_{{ $field->slug }}" id="field_{{ $field->slug }}" value="{{ $field->value }}" min="0" step="1" autocomplete="off"/>
      @else
        <input class="form-control" type="text" name="field_{{ $field->slug }}" id="field_{{ $field->slug }}" value="{{ $field->value }}" autocomplete="off"/>
      @endif
    </div>
  @endforeach
  <div class="input-group input-group-sm mt-3">
    <span class="input-group-text col-md-3">{{ __('profile.newpassword') }}</span>
    <input class="form-control" type="password" name="password" id="password" />
  </div>
  <div class="input-group input-group-sm">
    <span class="input-group-text col-md-3">{{ __('passwords.confirm') }}</span>
    <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" />
  </div>
  <div class="input-group input-group-sm mt-3">
    <span class="input-group-text col-md-3">{{ __('profile.opt-in') }}</span>
    <div class="input-group-text">
      <input type="hidden" name="opt_in" value="0" />
      <input class="form-check-input mt-0" type="checkbox" name="opt_in" id="opt_in" value="1" checked="{{ $user->opt_in }}">
    </div>
    <input type="text" class="form-control" value="{{ __('profile.opt-in-descrip') }}" disabled>
  </div>
</div>

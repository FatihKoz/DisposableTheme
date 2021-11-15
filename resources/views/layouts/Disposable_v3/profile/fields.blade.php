@php
  $disable_hub = (Theme::getSetting('user_disable_hub')) ? 'disabled' : null;
  $disable_airline = (Theme::getSetting('user_disable_airline')) ? 'disabled' : null;
@endphp
<div class="form-group">
  <div class="input-group input-group-sm">
    <span class="input-group-text col-3">{{ __('common.name') }}</span>
    {{ Form::text('name', null, ['class' => 'form-control']) }}
  </div>

  <div class="input-group input-group-sm">
    <span class="input-group-text col-3">{{ __('common.email') }}</span>
    {{ Form::text('email', null, ['class' => 'form-control']) }}
  </div>

  <div class="input-group input-group-sm">
    <span class="input-group-text col-3">
      Discord ID
      <a href="https://support.discord.com/hc/en-us/articles/206346498-Where-can-I-find-my-User-Server-Message-ID-" target="_blank">
        <i class="fas fa-info-circle text-primary mx-2" title="How to find your ID ?"></i>
      </a>
    </span>
    {{ Form::text('discord_id', null, ['class' => 'form-control']) }}
  </div>

  <div class="input-group input-group-sm mb-3">
    <span class="input-group-text col-3">
      {{ __('profile.avatar') }}
      <i class="fas fa-info-circle text-primary mt-1 mx-2" title="{{ __('profile.avatarresize', ['width' => config('phpvms.avatar.width'), 'height' => config('phpvms.avatar.height')]) }}"></i>
    </span>
    {{ Form::file('avatar', ['class' => 'form-control']) }}
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
    <span class="input-group-text col-3">{{ __('common.timezone') }}</span>
    {{ Form::select('timezone', $timezones, null, ['class' => 'form-control select2' ]) }}
  </div>

  <div class="input-group input-group-sm mb-3">
    <div class="input-group-text col-3">{{ __('common.country') }}</div>
    {{ Form::select('country', $countries, null, ['class' => 'form-control select2' ]) }}
  </div>

  <div class="input-group input-group-sm">
    <span class="input-group-text col-3">{{ __('airports.home') }}</span>
    {{ Form::hidden('home_airport_id', $user->home_airport_id, false) }}
    {{ Form::select('home_airport_id', $airports, null , ['class' => 'form-control select2 ', $disable_hub]) }}
  </div>

  <div class="input-group input-group-sm mb-3">
    <span class="input-group-text col-3">{{ __('common.airline') }}</span>
    {{ Form::hidden('airline_id', $user->airline_id, false) }}
    {{ Form::select('airline_id', $airlines, null , ['class' => 'form-control select2', $disable_airline]) }}
  </div>

  {{-- Custom fields --}}
  @foreach($userFields as $field)
    <div class="input-group input-group-sm">
      <span class="input-group-text col-3">
        {{ $field->name }}
        @if($field->required === true)
          <span class="mx-2 text-danger fw-bold">*</span>
        @endif
        @if(filled($field->description))
          <i class="fas fa-info-circle text-primary mx-2" title="{{ $field->description }}"></i>
        @endif
      </span>
      {{ Form::text('field_'.$field->slug, $field->value, ['class' => 'form-control']) }}
    </div>
  @endforeach

  <div class="input-group input-group-sm mt-3">
    <span class="input-group-text col-3">{{ __('profile.newpassword') }}</span>
    {{ Form::password('password', ['class' => 'form-control']) }}
  </div>

  <div class="input-group input-group-sm">
    <span class="input-group-text col-3">{{ __('passwords.confirm') }}</span>
    {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
  </div>

  <div class="input-group input-group-sm mt-3">
    <span class="input-group-text col-3">{{ __('profile.opt-in') }}</span>
    <div class="input-group-text">
      {{ Form::hidden('opt_in', 0, false) }}
      {{ Form::checkbox('opt_in', 1, $user->opt_in, ['class' => 'form-check-input mt-0']) }}
    </div>
    <input type="text" class="form-control" value="{{ __('profile.opt-in-descrip') }}" disabled>
  </div>
</div>

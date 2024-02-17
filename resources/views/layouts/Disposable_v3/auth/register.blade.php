@extends('app')
@section('title', __('auth.register'))
@php
  $only_hubs = ($hubs_only === true) ? 'hubs_only' : null;
@endphp
@section('content')
  <div class="row mt-2">
    <div class="col-lg-6 mx-auto content-center">
      <form class="form-control bg-transparent border-0" methot="post" action="{{ url('/register') }}">
        @csrf
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
              <span class="input-group-text col-lg-3">@lang('auth.fullname')</span>
              <input class="form-control" type="text" name="name" id="name" />
            </div>
            <div class="input-group input-group-sm mb-1">
              <span class="input-group-text col-lg-3">@lang('auth.emailaddress')</span>
              <input class="form-control" type="email" name="email" id="email" />
            </div>
            <div class="input-group input-group-sm mb-1">
              <span class="input-group-text col-lg-3">@lang('common.airline')</span>
              <select class="form-control select2" name="airline_id" id="airline_id">
                @foreach($airlines as $airline_id => $airline_label)
                  <option value="{{ $airline_id }}" @if($airline_id === old('airline_id')) selected @endif>{{ $airline_label }}</option>
                @endforeach
              </select>
            </div>
            <div class="input-group input-group-sm mb-1">
              <span class="input-group-text col-lg-3">@lang('airports.home')</span>
              <select class="form-control airport_search {{ $only_hubs }}" name="home_airport_id" id="home_airport_id">
                @foreach($airports as $airport_id => $airport_label)
                  <option value="{{ $airport_id }}">{{ $airport_label }}</option>
                @endforeach
              </select>
            </div>
            <div class="input-group input-group-sm mb-1">
              <span class="input-group-text col-lg-3">@lang('common.country')</span>
              <select class="form-control select2" name="country" id="country">
                @foreach($countries as $country_id => $country_label)
                  <option value="{{ $country_id }}" @if($country_id === old('country')) selected @endif>{{ $country_label }}</option>
                @endforeach
              </select>
            </div>
            <div class="input-group input-group-sm mb-1">
              <span class="input-group-text col-lg-3">@lang('common.timezone')</span>
              <select class="form-control select2" name="timezone" id="timezone">
                @foreach($timezones as $group_name => $group_timezones)
                  <optgroup label="{{ $group_name }}">
                    @foreach($group_timezones as $timezone_id => $timezone_label)
                      <option value="{{ $timezone_id }}" @if($timezone_id === old('timezone')) selected @endif>{{ $timezone_label }}</option>
                    @endforeach
                  </optgroup>
                @endforeach
              </select>
            </div>
            @if(setting('pilots.allow_transfer_hours') === true)
              <div class="input-group input-group-sm mb-1">
                <span class="input-group-text col-lg-3">@lang('auth.transferhours')</span>
                <input class="form-control" type="number" name="transfer_time" id="transfer_time" value="0" />
              </div>
            @endif
            <div class="input-group input-group-sm mb-1">
              <span class="input-group-text col-lg-3">@lang('auth.password')</span>
              <input class="form-control" type="password" name="password" id="password" autocomplete="off" />
            </div>
            <div class="input-group input-group-sm mb-1">
              <span class="input-group-text col-lg-3">@lang('passwords.confirm')</span>
              <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" autocomplete="off" />
            </div>
            @if($userFields)
              @foreach($userFields as $field)
                <div class="input-group input-group-sm mb-1">
                  <span class="input-group-text col-lg-3">
                    {{ $field->name }}
                    @if(filled($field->description))
                      <i class="fas fa-info-circle text-primary mx-2" title="{{ $field->description }}"></i>
                    @endif
                  </span>
                  @if(in_array(strtoupper($field->name), ['IVAO', 'IVAO ID', 'IVAO CID', 'VATSIM', 'VATSIM ID', 'VATSIM CID']))
                    <input class="form-control" type="number" name="field_{{ $field->slug }}" id="field_{{ $field->slug }}" value="{{ $field->value }}" min="0" step="1" autocomplete="off" />
                  @else
                    <input class="form-control" type="text" name="field_{{ $field->slug }}" id="field_{{ $field->slug }}" value="{{ $field->value }}" autocomplete="off" />
                  @endif
                </div>
              @endforeach
            @endif
            @if(isset($invite) && $invite)
              <input type="hidden" name="invite" value="{{ $invite->id }}" />
              <input type="hidden" name="invite_token" value="{{ base64_encode($invite->token) }}" />
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
                    <input type="hidden" name="toc_accepted" value="0" />
                    <input type="checkbox" name="toc_accepted" id="toc_accepted" value="1" />
                  </div>
                </td>
                <td>
                  <label for="toc_accepted" class="control-label">@lang('auth.tocaccept')</label>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="input-group ms-2">
                    <input type="hidden" name="opt_in" value="0" />
                    <input type="checkbox" name="opt_in" id="opt_in" value="1" />
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
              <div class="col d-grid">
                <button class="btn btn-sm btn-primary" type="submit" id="register_button" disabled="true">@lang('auth.register')</button>
              </div>
            </div>
          </div>
        </div>
      </form>
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
      } else {
        console.log('toc not accepted');
        $('#register_button').attr('disabled', 'true');
      }
    });
  </script>
  @include('scripts.airport_search')
@endsection

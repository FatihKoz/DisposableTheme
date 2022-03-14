@extends('app')
@section('title', __('common.profile'))
@include('theme_helpers')
@php
  $units = isset($units) ? $units : DT_GetUnits();
  $DBasic = isset($DBasic) ? $DBasic : DT_CheckModule('DisposableBasic');
  $DSpecial = isset($DSpecial) ? $DSpecial : DT_CheckModule('DisposableSpecial');
  $Auth_ID = Auth::id();
  $ivao_id = optional($user->fields->firstWhere('name', Theme::getSetting('gen_ivao_field')))->value;
  $vatsim_id = optional($user->fields->firstWhere('name', Theme::getSetting('gen_vatsim_field')))->value;
  $AdminCheck = false;
@endphp
@ability('admin', 'admin-access')
  @php $AdminCheck = true; @endphp
@endability
@section('content')
  <div class="row">
    <div class="col-lg-3">
      {{-- Pilot ID Card --}}
      <div class="card mb-2">
        <div class="card-header p-1">
          <h5 class="m-1">
            @if(Theme::getSetting('roster_ident')) {{ $user->ident.' | ' }} @endif
            {{ $user->name_private }}
            <span class="flag-icon flag-icon-{{ $user->country }} float-end mt-1"></span>
          </h5>
        </div>
        <div class="card-body p-0">
          <div class="card border-0 shadow-none bg-transparent mb-0">
            <div class="row g-0 mb-0 @if($user->state != 1) {!! DT_UserState($user, 'bg_add') !!} @endif">
              <div class="col-4 ps-1 pe-0 py-1">
                @if($user->avatar == null)
                  <img class="img-mh125 rounded-end border border-dark" src="{{ $user->gravatar(512) }}">
                @else
                  <img class="img-mh125 rounded-end border border-dark" src="{{ $user->avatar->url }}">
                @endif
              </div>
              <div class="col-8">
                <div class="card-body p-0 table-responsive">
                  <table class="table table-sm table-borderless mb-0 align-middle">
                    <tr>
                      <th colspan="2">{{ optional($user->airline)->name.' / '.optional($user->rank)->name }}</th>
                    </tr>
                    <tr>
                      <td class="text-center">
                        <a href='https://www.ivao.aero/Member.aspx?ID={{ $ivao_id }}' title="{{ Theme::getSetting('gen_ivao_field') }}" target='_blank'>{{ $ivao_id }}</a>
                      </td>
                      <td class="text-center">
                        <a href='https://stats.vatsim.net/search_id.php?id={{ $vatsim_id }}' title="{{ Theme::getSetting('gen_vatsim_field') }}" target='_blank'>{{ $vatsim_id }}</a>
                      </td>
                    </tr>
                    @if($user->id === $Auth_ID)
                      <tr>
                        <td colspan="2" >
                          <span id="email_show" style="display: none">
                            <i class="fas fa-eye-slash mx-1" onclick="emailHide()"></i>
                            {{ $user->email }}
                          </span>
                          <span id="email_hide">
                            <i class="fas fa-eye mx-1" onclick="emailShow()"></i>
                            E-mail
                          </span>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" title="@lang('profile.dontshare')">
                          <span id="apiKey_show" style="display: none">
                            <i class="fas fa-eye-slash mx-1" onclick="apiKeyHide()"></i>
                            {{ $user->api_key }}
                          </span>
                          <span id="apiKey_hide">
                            <i class="fas fa-eye mx-1" onclick="apiKeyShow()"></i>
                            @lang('profile.apikey')
                          </span>
                        </td>
                      </tr>
                    @endif
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer p-1 small fw-bold">
          <span class="float-start">
            @if($DBasic)
              <a href="{{ route('DBasic.hub', [$user->home_airport_id ?? '']) }}">
            @else
              <a href="{{ route('frontend.airports.show', [$user->home_airport_id ?? '']) }}">
            @endif
            {{ optional($user->home_airport)->full_name ?? $user->home_airport_id }}
            </a>
          </span>
          <span class="float-end">
            @if(filled($user->discord_id))
              <i class="fab fa-discord mx-1" @ability('admin', 'admin-access') title="{{ $user->discord_id }}" @endability></i>
            @endif
            @if($user->opt_in)
              <i class="fas fa-envelope mx-1"></i>
            @endif
            @if(filled($user->timezone))
              <i class="fas fa-user-clock mx-1" title="@lang('common.timezone'): {{ $user->timezone }}"></i>
            @endif
            <i class="fas fa-calendar-plus mx-1" title="Member since {{ $user->created_at->format('l d.M.Y') }}"></i>
          </span>
        </div>
        {{-- Action Buttons --}}
        @if($user->id === $Auth_ID)
          <div class="card-footer p-1">
            @if(isset($acars) && $acars === true)
                <a href="{{ route('frontend.profile.acars') }}" class="btn btn-sm btn-success m-0 mx-1 p-0 px-2" onclick="alert('Copy or Save to \'My Documents/phpVMS\'')">
                  <i class="fas fa-file-download text-black" title="Download vmsAcars Config"></i>
                </a>
            @endif
            <a href="{{ route('frontend.profile.regen_apikey') }}" class="btn btn-sm btn-warning m-0 mx-1 p-0 px-2" onclick="return confirm('Are you sure? This will reset your API key!')">
              <i class="fas fa-key text-black" title="@lang('profile.newapikey')"></i>
            </a>
            <a href="{{ route('frontend.profile.edit', [$user->id]) }}" class="btn btn-sm btn-primary m-0 mx-1 p-0 px-2">
              <i class="fas fa-edit text-black" title="@lang('common.edit')"></i>
            </a>
            @if($DBasic && $user->flights > 0 && $user->id === Auth::id())
              <span class="float-end mb-0">
                @widget('DBasic::Map', ['source' => 'user'])
              </span>
            @endif
          </div>
        @endif
      </div>
      {{-- Inline Navigation --}}
      <ul class="nav nav-pills nav-fill mb-2" id="details-tab" role="tablist">
        @if($Auth_ID)
          <li class="nav-item mx-1" role="presentation">
            <button class="nav-link p-0 px-1" id="profile-tab" data-bs-toggle="pill" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true">
              Profile Details</button>
          </li>
        @endif
        @if($user->typeratings->count() > 0)
          <li class="nav-item mx-1" role="presentation">
            <button class="nav-link p-0 px-1" id="typeratings-tab" data-bs-toggle="pill" data-bs-target="#typeratings" type="button" role="tab" aria-controls="typeratingss" aria-selected="false">
              Type Ratings
            </button>
          </li>
        @endif
        @if(filled($user->awards))
          <li class="nav-item mx-1" role="presentation">
            <button class="nav-link p-0 px-1" id="awards-tab" data-bs-toggle="pill" data-bs-target="#awards" type="button" role="tab" aria-controls="awards" aria-selected="false">
              Awards
            </button>
          </li>
        @endif
        @if($DBasic && $user->flights > 0)
          <li class="nav-item mx-1" role="presentation">
            <button class="nav-link p-0 px-1" id="stats-tab" data-bs-toggle="pill" data-bs-target="#stats" type="button" role="tab" aria-controls="stats" aria-selected="false">
              Statistics
            </button>
          </li>
        @endif
      </ul>
    </div>
    {{-- Info Boxes --}}
    <div class="col-lg-9">
      <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5">
        <div class="col">
          {{-- Current Airport --}}
          <div class="card text-center mb-2">
            <div class="card-body p-2">
              @if(filled($user->curr_airport_id) || filled($user->home_airport_id))
                <a
                  href="{{ route('frontend.airports.show', [$user->curr_airport_id ?? $user->home_airport_id]) }}"
                  title="{{ optional($user->current_airport)->name ?? optional($user->home_airport)->name }}">
                  {{ $user->curr_airport_id ?? $user->home_airport_id }}
                </a>
              @else
               --
              @endif
            </div>
            <div class="card-footer p-0 small fw-bold">
              Current Location
            </div>
          </div>
        </div>

        <div class="col">
          {{-- Last Pirep --}}
          <div class="card text-center mb-2">
            <div class="card-body p-2">
              @if($user->last_pirep)
                {{ $user->last_pirep->submitted_at->diffForHumans() }}
              @else
                --
              @endif
            </div>
            <div class="card-footer p-0 small fw-bold">
              Last Flight
            </div>
          </div>
        </div>

        <div class="col">
          {{-- Flights --}}
          <div class="card text-center mb-2">
            <div class="card-body p-2">
              {{ $user->flights }}
            </div>
            <div class="card-footer p-0 small fw-bold">
              Flights
            </div>
          </div>
        </div>

        <div class="col">
          {{-- Flight Time --}}
          <div class="card text-center mb-2">
            <div class="card-body p-2">
              @minutestotime($user->flight_time)
            </div>
            <div class="card-footer p-0 small fw-bold">
              Flight Time
            </div>
          </div>
        </div>

        <div class="col">
          {{-- Transfer Time --}}
          @if(setting('pilots.allow_transfer_hours') === true || filled($user->transfer_time))
            <div class="card text-center mb-2">
              <div class="card-body p-2">
                @minutestohours($user->transfer_time)h
              </div>
              <div class="card-footer p-0 small fw-bold">
                Transfer Time
              </div>
            </div>
          @endif
        </div>
      </div>

      @if($DBasic && $user->flights > 0)
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5">
          <div class="col">
            @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'avgscore'])
            {{-- User Balance and Last Transactions Display --}}
            @if($Auth_ID || $AdminCheck)
              @widget('DBasic::JournalDetails', ['user' => $user->id, 'card' => true, 'limit' => 20])
            @endif
            {{-- End User Balance Section --}}
          </div>
          <div class="col">
            @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'avglanding'])
            @if(Theme::getSetting('gen_stable_approach'))
              @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'fdm'])
            @endif
          </div>
          <div class="col">
            @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'avgtime'])
            @if($DSpecial)
              @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'assignment'])
            @endif
          </div>
          <div class="col">
            @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'avgdistance'])
            @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'totdistance'])
          </div>
          <div class="col">
            @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'avgfuel'])
            @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'totfuel'])
          </div>
        </div>
      @endif
    </div>
  </div>

  <div class="tab-content mt-2" id="details-tabContent">
    @if($Auth_ID)
      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        @include('profile.user_fields')
      </div>
    @endif
    @if($user->typeratings->count() > 0)
      <div class="tab-pane fade" id="typeratings" role="tabpanel" aria-labelledby="typeratings-tab">
        @include('profile.user_typeratings')
      </div>
    @endif
    @if(filled($user->awards))
      <div class="tab-pane fade" id="awards" role="tabpanel" aria-labelledby="awards-tab">
        @include('profile.user_awards')
      </div>
    @endif
    @if($DBasic && $user->flights > 0)
      <div class="tab-pane fade" id="stats" role="tabpanel" aria-labelledby="stats-tab">
        @include('profile.user_stats')
      </div>
    @endif
  </div>
@endsection

@section('scripts')
  @parent
  <script>
    function apiKeyShow(){
      document.getElementById("apiKey_show").style = "display:block";
      document.getElementById("apiKey_hide").style = "display:none";
    }
    function apiKeyHide(){
      document.getElementById("apiKey_show").style = "display:none";
      document.getElementById("apiKey_hide").style = "display:block";
    }
    function emailShow(){
      document.getElementById("email_show").style = "display:block";
      document.getElementById("email_hide").style = "display:none";
    }
    function emailHide(){
      document.getElementById("email_show").style = "display:none";
      document.getElementById("email_hide").style = "display:block";
    }
  </script>
@endsection

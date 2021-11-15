@extends('app')
@section('title', __('common.dashboard'))
@include('theme_helpers')
@php
  $DBasic = isset($DBasic) ? $DBasic : DT_CheckModule('DisposableBasic');
  $DSpecial = isset($DSpecial) ? $DSpecial : DT_CheckModule('DisposableSpecial');
  $units = isset($units) ? $units : DT_GetUnits();
@endphp
@section('content')
  {{-- User State Warning --}}
  @if($user->state === \App\Models\Enums\UserState::ON_LEAVE)
    <div class="row mb-1">
      <div class="col">
        <div class="alert alert-warning mb-1 p-1 px-2 fw-bold" role="alert">
          @lang('disposable.user_on_leave')
        </div>
      </div>
    </div>
  @endif
  {{-- Full row with more icons --}}
  @if($DBasic)
    @include('dashboard.icons')
  @endif

  <div class="row">
    {{-- Main Dashboard : LEFT --}}
    <div class="col-8">
      {{-- Only 4 icons with core data --}}
      @if(!$DBasic)
        @include('dashboard.icons')
      @endif
      @if(Theme::getSetting('dash_livemap'))
        @widget('liveMap', ['table' => false, 'height' => '500px'])
      @elseif($DBasic)
        @widget('DBasic::FlightBoard')
      @endif
      @if($last_pirep !== null)
        @include('dashboard.pirep_card', ['pirep' => $last_pirep])
      @endif
      @widget('latestNews', ['count' => 3])
      {{-- Jumpseat Traver and Aircraft Transfer Widgets--}}
      @if($DBasic)
        <div class="row">
          <div class="col">
            @widget('DBasic::JumpSeat')
          </div>
          <div class="col">
            @widget('DBasic::TransferAircraft')
          </div>
        </div>
      @endif
      {{-- Current Month Leaderboard Widgets--}}
      @if($DBasic)
        <div class="row">
          <div class="col">
            @widget('DBasic::LeaderBoard', ['source' => 'pilot', 'period' => 'currentm', 'count' => 5, 'type' => 'flights'])
          </div>
          <div class="col">
            @widget('DBasic::LeaderBoard', ['source' => 'pilot', 'period' => 'currentm', 'count' => 5, 'type' => 'time'])
          </div>
          <div class="col">
            @widget('DBasic::LeaderBoard', ['source' => 'pilot', 'period' => 'currentm', 'count' => 5, 'type' => 'lrate'])
          </div>
        </div>
      @endif
    </div>
    {{-- Main Dashboard : RIGHT --}}
    <div class="col-4">
      @if(Theme::getSetting('dash_embed_wx') && $current_airport)
        <div class="card p-0 mb-2 bg-transparent">
          <iframe style="pointer-events: none; border-radius: 5px;" src="https://metar-taf.com/embed/{{ $current_airport }}?bg_color=811608E6&layout=landscape" frameBorder="0" width="100%" height="256" scrolling="no"></iframe>
        </div>
      @elseif($current_airport)
        @widget('Weather', ['icao' => $current_airport])
      @endif
      {{-- Two Map side by side positioning --}}
      <div class="row">
        <div class="col">
          @if($DBasic && Theme::getSetting('gen_map_flight'))
            @widget('DBasic::Map', ['source' => $current_airport])
          @endif
        </div>
        <div class="col">
          @if($DBasic && Theme::getSetting('gen_map_fleet'))
            @widget('DBasic::Map', ['source' => 'fleet'])
          @endif
        </div>
      </div>
      @if($DSpecial)
        @widget('DSpecial::Assignments')
      @endif
      @if($DBasic)
        @if(Theme::getSetting('dash_whazzup_ivao'))
          @asyncWidget('DBasic::WhazzUp', ['network' => 'IVAO'])
        @endif
        @if(Theme::getSetting('dash_whazzup_vatsim'))
          @asyncWidget('DBasic::WhazzUp', ['network' => 'VATSIM'])
        @endif
        @widget('DBasic::RandomFlights')
        @widget('DBasic::AirportInfo')
        @widget('DBasic::Discord')
      @endif
      @if(!$DBasic)
        @widget('latestPireps', ['count' => 5])
        @widget('latestPilots', ['count' => 5])
      @endif
    </div>
  </div>
@endsection

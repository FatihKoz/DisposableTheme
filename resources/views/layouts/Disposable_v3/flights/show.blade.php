@extends('app')
@section('title', trans_choice('common.flight', 1).' '.$flight->ident)
@include('theme_helpers')
@php
  $units = isset($units) ? $units : DT_GetUnits();
  $DBasic = isset($DBasic) ? $DBasic : DT_CheckModule('DisposableBasic');
  $DSpecial = isset($DSpecial) ? $DSpecial : DT_CheckModule('DisposableSpecial');
@endphp
@section('content')
  <div class="row">
    <div class="col-8">
      <div class="card mb-2">
        <div class="card-header p-1">
          <h5 class="m-1">
            {{ optional($flight->airline)->code.' '.$flight->flight_number.' | ' }}
            @if(Theme::getSetting('flights_flags'))
              <img class="img-mh20 mx-1" src="{{ public_asset('/image/flags_new/'.strtolower(optional($flight->dpt_airport)->country).'.png') }}" alt=""/>
            @endif
            {{ optional($flight->dpt_airport)->location.' > '.optional($flight->arr_airport)->location }}
            @if(Theme::getSetting('flights_flags'))
              <img class="img-mh20 mx-1" src="{{ public_asset('/image/flags_new/'.strtolower(optional($flight->arr_airport)->country).'.png') }}" alt=""/>
            @endif
            @if(filled($flight->callsign))
              <span class="float-end">{{ optional($flight->airline)->icao.' '.$flight->callsign }}</span>
            @endif
          </h5>
        </div>
        <div class="card-body p-0">
          <div class="row">
            <div class="col text-start">
              <i class="fas fa-plane-departure float-start m-1"></i>
              <a href="{{route('frontend.airports.show', ['id' => $flight->dpt_airport_id])}}">
                {{ optional($flight->dpt_airport)->full_name ?? $flight->dpt_airport_id }}
              </a>
            </div>
            <div class="col text-center">
              <i class="fas fa-route m-1"></i>
              {{ DT_ConvertDistance($flight->distance) }}
            </div>
            <div class="col text-end">
              <i class="fas fa-plane-arrival float-end m-1"></i>
              <a href="{{route('frontend.airports.show', ['id' => $flight->arr_airport_id])}}">
                {{ optional($flight->arr_airport)->full_name ?? $flight->arr_airport_id }}
              </a>
            </div>
          </div>
          <div class="row">
            <div class="col text-start">
              @if(filled($flight->dpt_time))
                <i class="fas fa-clock float-start m-1"></i>
                {{ DT_FormatScheduleTime($flight->dpt_time) }}
              @endif
            </div>
            <div class="col text-center">
              {{ DT_FlightDays($flight->days) }}
            </div>
            <div class="col text-end">
              @if(filled($flight->arr_time))
                <i class="fas fa-clock float-end m-1"></i>
                {{ DT_FormatScheduleTime($flight->arr_time) }}
              @endif
            </div>
          </div>
          @if(filled($flight->start_date) || filled($flight->end_date) || filled($flight->alt_airport_id))
            <div class="row">
              <div class="col text-start">
                {{-- Blank --}}
              </div>
              <div class="col text-center">
                @if($flight->start_date)
                  <i class="fas fa-calendar-plus mx-1" title="Start Date"></i>
                  {{ $flight->start_date->format('l, d.M.Y') }}
                @endif
                @if($flight->end_date)
                  <i class="fas fa-calendar-minus mx-1" title="End Date"></i>
                  {{ $flight->end_date->format('l, d.M.Y') }}
                @endif
              </div>
              <div class="col text-end">
                @if(filled($flight->alt_airport_id))
                  <i class="fas fa-map-marker-alt float-end m-1" title="Preferred Alternate Aerodrome"></i>
                  <a href="{{ route('frontend.airports.show', [$flight->alt_airport_id]) }}">
                    {{ optional($flight->alt_airport)->full_name }}
                  </a>
                @endif
              </div>
            </div>
          @endif
          @if($flight->subfleets->count() > 0)
            <div class="card-footer p-1">
              <i class="fas fa-link me-1" title="Subfleets"></i>
              @foreach($flight->subfleets as $sf)
                @if(!$loop->first) &bull; @endif
                @if($DBasic)
                  <a href="{{ route('DBasic.subfleet', [$sf->type]) }}">{{ $sf->name.' | '.optional($sf->airline)->icao }}</a>
                @else
                  {{ $sf->name.' | '.optional($sf->airline)->icao }}
                @endif
              @endforeach
            </div>
          @endif
        </div>
        @if(filled($flight->notes))
          <div class="card-footer bg-transparent p-1">
            {!! $flight->notes !!}
          </div>
        @endif
        <div class="card-footer p-1">
          <div class="row">
            <div class="col text-start">
              {!! DT_FlightType($flight->flight_type, 'button') !!}
            </div>
            <div class="col text-center">
              <i class="fas fa-stopwatch m-1"></i>
              {{ DT_ConvertMinutes($flight->flight_time, '%2dh %2dm') }}
            </div>
            <div class="col text-end">
              {!! DT_RouteCode($flight->route_code, 'button') !!} {!! DT_RouteLeg($flight->route_leg, 'button') !!}
            </div>
          </div>
        </div>
      </div>

      <div class="card mb-2">
        <div class="card-header p-1">
          <h5 class="m-1">
            @lang('disposable.map')
            <i class="fas fa-map-marked float-end"></i>
          </h5>
        </div>
        <div class="card-body p-0">
          @include('flights.map')
        </div>
        @if(filled($flight->route))
          <div class="card-footer p-0 table-responsive">
            <table class="table table-sm table-borderless align-middle mb-0">
              <tr>
                <td class="text-start" style="width: 2%;">
                  <i class="fas fa-route m-1"></i>
                </td>
                <td class="text-start">
                  {{ $flight->route }}
                </td>
                <td class="text-end">
                  <a
                    class="btn btn-sm btn-info m-0 mx-1 p-0 px-1"
                    href="http://skyvector.com/?chart=304&fpl={{ $flight->dpt_airport_id }} {{ $flight->route }} {{ $flight->arr_airport_id }}"
                    target="_blank">
                    View at SkyVector
                  </a>
                </td>
              </tr>
            </table>
          </div>
        @endif
      </div>
    </div>

    <div class="col-4">
      {{-- Inline navigation for WX Widgets --}}
      <ul class="nav nav-pills nav-justified mb-2" id="pills-tab" role="tablist">
        <li class="nav-item mx-1" role="presentation">
          <button class="nav-link p-1 active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
            @lang('airports.departure')
          </button>
        </li>
        <li class="nav-item mx-1" role="presentation">
          <button class="nav-link p-1" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">
            @lang('airports.arrival')
          </button>
        </li>
        @if(filled($flight->alt_airport_id))
          <li class="nav-item mx-1" role="presentation">
            <button class="nav-link p-1" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">
              @lang('flights.alternateairport')
            </button>
          </li>
        @endif
      </ul>
      {{-- Navigation content --}}
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
          @widget('Weather', ['icao' => $flight->dpt_airport_id])
          @if($DBasic)
            @widget('DBasic::SunriseSunset', ['location' => $flight->dpt_airport_id])
          @endif
          @if($DSpecial && Theme::getSetting('flight_notams'))
            @widget('DSpecial::Notams', ['airport' => $flight->dpt_airport_id])
          @endif
        </div>
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
          @widget('Weather', ['icao' => $flight->arr_airport_id])
          @if($DBasic)
            @widget('DBasic::SunriseSunset', ['location' => $flight->arr_airport_id])
          @endif
          @if($DSpecial && Theme::getSetting('flight_notams'))
            @widget('DSpecial::Notams', ['airport' => $flight->arr_airport_id])
          @endif
        </div>
        @if(filled($flight->alt_airport_id))
          <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
            @widget('Weather', ['icao' => $flight->alt_airport_id])
            @if($DBasic)
              @widget('DBasic::SunriseSunset', ['location' => $flight->alt_airport_id])
            @endif
            @if($DSpecial && Theme::getSetting('flight_notams'))
              @widget('DSpecial::Notams', ['airport' => $flight->alt_airport_id])
            @endif
          </div>
        @endif
      </div>
      {{-- Generic Buttons --}}
      <div class="text-center">
        @if(Theme::getSetting('flight_bid'))
          @if(!setting('pilots.only_flights_from_current') || $flight->dpt_airport_id === Auth::user()->curr_airport_id)
            {{-- !!! IMPORTANT NOTE !!! Don't remove the "save_flight" class, It will break the AJAX to save/delete --}}
            <span class="btn btn-sm save_flight {{isset($bid) ? 'btn-danger':'btn-success'}} mx-1" onclick="AddRemoveBid('{{isset($bid) ? 'remove':'add'}}')">
              {{isset($bid) ? __('disposable.bid_rem'): __('disposable.bid_add')}}
            </span>
          @endif
        @endif
        @if(Theme::getSetting('flight_simbrief') && filled(setting('simbrief.api_key')))
          @if(!setting('simbrief.only_bids') || setting('simbrief.only_bids') && isset($bid))
            @if($flight->simbrief && $flight->simbrief->user_id == Auth::user()->id)
              <a id="mylink" href="{{ route('frontend.simbrief.briefing', $flight->simbrief->id) }}" class="btn btn-sm btn-secondary mx-1">
                @lang('disposable.sb_view')
              </a>
            @else
              <a id="mylink" href="{{ route('frontend.simbrief.generate') }}?flight_id={{ $flight->id }}" class="btn btn-sm btn-primary mx-1">
                @lang('disposable.sb_generate')
              </a>
            @endif
          @endif
        @endif
        @if($acars_plugin && isset($bid))
          <a href="vmsacars:bid/{{ $bid->id }}" class="btn btn-sm btn-warning mx-1">
            @lang('disposable.load_acars')
          </a>
        @elseif($acars_plugin)
          <a href="vmsacars:flight/{{ $flight->id }}" class="btn btn-sm btn-warning mx-1">
            @lang('disposable.load_acars')
          </a>
        @endif
        @if(Theme::getSetting('pireps_manual'))
          <a href="{{ route('frontend.pireps.create') }}?flight_id={{ $flight->id }}" class="btn btn-sm btn-info mx-1">
            @lang('disposable.new_pirep')
          </a>
        @endif
      </div>
    </div>
  </div>
@endsection

{{-- DO NOT REMOVE THIS SCRIPT IT IS USED FOR BIDDING FROM FLIGHT DETAILS PAGE --}}
@if(Theme::getSetting('flight_bid'))
  @section('scripts')
    @parent
    <script type="text/javascript">
      async function AddRemoveBid(action) {

        const flight_id = "{{$flight->id}}";

        if (action === "add") {
          await phpvms.bids.addBid(flight_id);
          console.log('successfully saved flight');
          alert('@lang("flights.bidadded")');
          location.reload();
        } else {
          await phpvms.bids.removeBid(flight_id);
          console.log('successfully removed flight');
          alert('@lang("flights.bidremoved")');
          location.reload();
        }
      }
    </script>
  @endsection
@endif
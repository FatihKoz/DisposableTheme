@foreach($flights as $flight)
  <div class="card mb-2">
    <div class="card-header p-0 table-responsive">
      <table class="table table-sm table-borderless align-middle mb-0">
        <tr>
          @if(optional($flight->airline)->logo)
            <td class="text-start col-1">
              <img class="img-mh35" src="{{ $flight->airline->logo }}"  alt="{{ optional($flight->airline)->name }}"/>
            </td>
          @endif
          <th class="text-start">
            <h5 class="m-0 p-0">
              {{ optional($flight->airline)->code.' '.$flight->flight_number }}
              @if(filled($flight->callsign))
                {{ ' | '.optional($flight->airline)->icao.' '.$flight->callsign }}
              @endif
              {{ ' | '.optional($flight->dpt_airport)->location.' > '.optional($flight->arr_airport)->location }}
            </h5>
          </th>
          <th class="text-end col-2">
            <h5 class="m-0 p-0">
              <a data-bs-toggle="collapse" href="#Details{{ $flight->id }}" role="button" aria-expanded="false" aria-controls="Details{{ $flight->id }}">
                <i class="fas fa-angle-double-down mx-1"></i>
              </a>
              <a href="{{ route('frontend.flights.show', [$flight->id]) }}">
                <i class="fas fa-info-circle mx-1"></i>
              </a>
            </h5>
          </th>
        </tr>
      </table>
    </div>
    <div class="card-body p-0">
      <div class="row">
        <div class="col-lg text-start">
          <i class="fas fa-plane-departure m-1"></i>
          <a href="{{route('frontend.airports.show', [$flight->dpt_airport_id])}}">
            {{ optional($flight->dpt_airport)->full_name ?? $flight->dpt_airport_id }}
          </a>
        </div>
        <div class="col-lg text-center">
          <i class="fas fa-route m-1"></i>
          {{ DT_ConvertDistance($flight->distance) }}
        </div>
        <div class="col-lg text-end">
          <a href="{{route('frontend.airports.show', [$flight->arr_airport_id])}}">
            {{ optional($flight->arr_airport)->full_name ?? $flight->arr_airport_id }}
          </a>
          <i class="fas fa-plane-arrival m-1"></i>
        </div>
      </div>
      <div class="row">
        <div class="col text-start">
          @if(filled($flight->dpt_time))
            <i class="fas fa-clock m-1"></i>
            {{ DT_FormatScheduleTime($flight->dpt_time) }}
          @endif
        </div>
        <div class="col text-center">
          <i class="fas fa-stopwatch me-1" title="Block Time"></i>
          {{ DT_ConvertMinutes($flight->flight_time, '%2dh %2dm') }}
        </div>
        <div class="col text-end">
          @if(filled($flight->arr_time))
            {{ DT_FormatScheduleTime($flight->arr_time) }}
            <i class="fas fa-clock m-1"></i>
          @endif
        </div>
      </div>
      <div class="collapse {{ $auto_extend }}" id="Details{{ $flight->id }}">
        {{-- This section is collapsed/hidden by default --}}
        <hr class="m-1 p-0">
        <div class="row mb-1">
          <div class="col-md text-start">
            @if($flight->start_date)
              <i class="fas fa-calendar-plus mx-1" title="Start Date"></i>
              {{ $flight->start_date->format('l, d.M.Y') }}
            @endif
            @if($flight->end_date)
              <i class="fas fa-calendar-minus mx-1" title="End Date"></i>
              {{ $flight->end_date->format('l, d.M.Y') }}
            @endif
          </div>
          <div class="col-md text-center">
            {{ DT_FlightDays($flight->days) }}
          </div>
          <div class="col-lg text-end">
            @if($flight->alt_airport_id)
              <a href="{{ route('frontend.airports.show', [$flight->alt_airport_id]) }}">
                {{ optional($flight->alt_airport)->full_name ?? $flight->alt_airport_id }}
              </a>
              <i class="fas fa-map-marker-alt m-1" title="Preferred Alternate Aerodrome"></i>
            @endif
          </div>
        </div>
        @if($flight->route)
          <div class="row mb-1">
            <div class="col">
              <i class="fas fa-route m-1" title="Preferred Route"></i>
              {{ $flight->route }}
              <a href="{{ 'http://skyvector.com/?chart=304&fpl='.$flight->dpt_airport_id.' '.$flight->route.' '.$flight->arr_airport_id }}" target="_blank">
                <span class="badge bg-info text-black mx-1">SkyVector</span>
              </a>
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
        @if($flight->notes)
          <div class="card-footer bg-transparent text-start p-1">
              {!! $flight->notes !!}
          </div>
        @endif
      </div>
    </div>
    <div class="card-footer p-1 text-center">
      <div class="row">
        {{-- Badges --}}
        <div class="col text-start">
          {!! DT_FlightType($flight->flight_type, 'button') !!}
          {!! DT_RouteCode($flight->route_code, 'button') !!}
          {!! DT_RouteLeg($flight->route_leg, 'button') !!}
        </div>
        {{-- Buttons --}}
        <div class="col text-end">
          {{--}}
            !!! NOTE FOR BID BUTTON !!!
            Don't remove the "save_flight" class, or the x-id attribute. It will break the AJAX to save/delete
            "x-saved-class" is the class to add/remove if the bid exists or not If you change it, remember to change it in the isset line as well
          {{--}}
          {{-- Bid Add/Remove --}}
          <button class="btn btn-sm save_flight m-0 mx-1 p-0 px-1 {{ isset($saved[$flight->id]) ? 'btn-danger':'btn-success' }}"
                  x-id="{{ $flight->id }}"
                  x-saved-class="btn-danger"
                  type="button">
            @lang('flights.addremovebid')
          </button>
          @if (!setting('pilots.only_flights_from_current') || $flight->dpt_airport_id == optional($user->current_airport)->icao)
            {{-- SimBrief --}}
            @if($simbrief !== false && $flight->simbrief && $flight->simbrief->user_id === $user->id)
              <a href="{{ route('frontend.simbrief.briefing', $flight->simbrief->id) }}" class="btn btn-sm btn-secondary m-0 mx-1 p-0 px-1">@lang('disposable.sb_view')</a>
            @elseif($simbrief !== false && ($simbrief_bids === false || $simbrief_bids === true && isset($saved[$flight->id])))
            @php
              $aircraft_id = isset($saved[$flight->id]) ? App\Models\Bid::find($saved[$flight->id])->aircraft_id : null;
            @endphp
              <a href="{{ route('frontend.simbrief.generate') }}?flight_id={{ $flight->id }}@if($aircraft_id)&aircraft_id={{ $aircraft_id }} @endif" class="btn btn-sm btn-primary m-0 mx-1 p-0 px-1">@lang('disposable.sb_generate')</a>
            @endif
            {{-- vmsACARS --}}
            @if($acars_plugin && isset($saved[$flight->id]))
              <a href="vmsacars:bid/{{ $saved[$flight->id] }}" class="btn btn-sm btn-warning m-0 mx-1 p-0 px-1">@lang('disposable.load_acars')</a>
            @elseif($acars_plugin)
              <a href="vmsacars:flight/{{ $flight->id }}" class="btn btn-sm btn-warning m-0 mx-1 p-0 px-1">@lang('disposable.load_acars')</a>
            @endif
            {{-- Manual Pirep --}}
            @if(Theme::getSetting('pireps_manual'))
              <a href="{{ route('frontend.pireps.create') }}?flight_id={{ $flight->id }}" class="btn btn-sm btn-info m-0 mx-1 p-0 px-1">
                @lang('disposable.new_pirep')
              </a>
            @endif
          @endif
        </div>
      </div>
    </div>
  </div>
  <div class="row collapse {{ $auto_extend }}" id="Details{{ $flight->id }}">
    <div class="col-lg-4">
      @widget('Weather', ['icao' => $flight->dpt_airport_id])
    </div>
    <div class="col-lg-4">
      @widget('Weather', ['icao' => $flight->arr_airport_id])
    </div>
    <div class="col-lg-4">
      @if(filled($flight->alt_airport_id))
        @widget('Weather', ['icao' => $flight->alt_airport_id])
      @endif
    </div>
  </div>
@endforeach
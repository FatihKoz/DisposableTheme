<table class="table table-sm table-borderless table-striped align-middle text-start text-nowrap mb-0">
  <thead>
    <tr>
      <th>@sortablelink('flight_number', __('flights.flightnumber'))</th>
      @if(Theme::getSetting('flights_codeleg'))
        <th>@sortablelink('route_code', 'Code')</th>
        <th>@sortablelink('route_leg', 'Leg')</th>
      @endif
      <th>@sortablelink('dpt_airport_id', __('airports.departure'))</th>
      <th class="text-center">@sortablelink('dpt_time', 'STD')</th>
      <th class="text-center">@sortablelink('arr_time', 'STA')</th>
      <th>@sortablelink('arr_airport_id', __('airports.arrival'))</th>
      <th class="text-end pe-2">@lang('disposable.actions')</th>
    </tr>
  </thead>
  <tbody>
    @foreach($flights as $flight)
      <tr>
        <td>
          <a href="{{ route('frontend.flights.show', [$flight->id]) }}">
            {{ optional($flight->airline)->code.' '.$flight->flight_number }}
            @if(filled($flight->route_code) && in_array($flight->route_code, $tour_codes))
              <span class="badge bg-warning text-black mx-1 px-1">Tour Flight</span>
            @endif
          </a>
        </td>
        @if(Theme::getSetting('flights_codeleg'))
          <td>{{ $flight->route_code }}</td>
          <td>{{ $flight->route_leg }}</td>
        @endif
        <td>
          @if(Theme::getSetting('flights_flags'))
            <img class="img-mh25 mx-1" title="{{ strtoupper(optional($flight->dpt_airport)->country) }}"
              src="{{ public_asset('/image/flags_new/'.strtolower(optional($flight->dpt_airport)->country).'.png') }}" alt=""/>
          @endif
          <a href="{{ route('frontend.airports.show', [$flight->dpt_airport_id]) }}">
            {{ $flight->dpt_airport->full_name ?? $flight->dpt_airport_id }}
          </a>
        </td>
        @if(filled($flight->dpt_time) && filled($flight->arr_time))
          <td class="text-center" title="{{ DT_FlightDays($flight->days) }}">{{ DT_FormatScheduleTime($flight->dpt_time) }}</td>
          <td class="text-center">{{ DT_FormatScheduleTime($flight->arr_time) }}</td>
        @else
          <td class="text-center" colspan="2" title="{{ DT_FlightDays($flight->days) }}">{{ DT_ConvertMinutes($flight->flight_time, '%2dh %2dm') }}</td>
        @endif
        <td>
          @if(Theme::getSetting('flights_flags'))
            <img class="img-mh25 mx-1" title="{{ strtoupper(optional($flight->arr_airport)->country) }}"
              src="{{ public_asset('/image/flags_new/'.strtolower(optional($flight->arr_airport)->country).'.png') }}" alt=""/>
          @endif
          <a href="{{ route('frontend.airports.show', [$flight->arr_airport_id]) }}">
            {{ $flight->arr_airport->full_name ?? $flight->arr_airport_id }}
          </a>
        </td>
        <td class="text-end">
          @if(!setting('pilots.only_flights_from_current') || $flight->dpt_airport_id == optional($user->current_airport)->icao)
            {{-- Bid --}}
            @if(setting('bids.allow_multiple_bids') === true || setting('bids.allow_multiple_bids') === false && count($saved) === 0)
              <button class="btn btn-sm m-0 mx-1 p-0 px-1 save_flight {{ isset($saved[$flight->id]) ? 'btn-danger':'btn-success' }}"
                      x-id="{{ $flight->id }}"
                      x-saved-class="btn-danger"
                      type="button" title="@lang('flights.addremovebid')">
                <i class="fas fa-map-marker"></i>
              </button>
            @endif
            {{-- Simbrief --}}
            @if($simbrief !== false && $flight->simbrief && $flight->simbrief->user_id === $user->id)
              <a href="{{ route('frontend.simbrief.briefing', $flight->simbrief->id) }}" class="btn btn-sm m-0 mx-1 p-0 px-1 btn-secondary">
                <i class="fas fa-file-pdf"  title="View SimBrief OFP"></i>
              </a>
            @elseif($simbrief !== false && ($simbrief_bids === false || $simbrief_bids === true && isset($saved[$flight->id])))
              @php
                $aircraft_id = isset($saved[$flight->id]) ? App\Models\Bid::find($saved[$flight->id])->aircraft_id : null;
              @endphp
              <a href="{{ route('frontend.simbrief.generate') }}?flight_id={{ $flight->id }}@if($aircraft_id)&aircraft_id={{ $aircraft_id }} @endif" class="btn btn-sm m-0 mx-1 p-0 px-1 {{ isset($saved[$flight->id]) ? 'btn-success':'btn-primary' }}">
                <i class="fas fa-file-pdf" title="Generate SimBrief OFP"></i>
              </a>
            @endif
            {{-- vmsAcars Load --}}
            @if($acars_plugin && isset($saved[$flight->id]))
              <a href="vmsacars:bid/{{ $saved[$flight->id] }}" class="btn btn-sm m-0 mx-1 p-0 px-1 btn-warning">
                <i class="fas fa-file-download" title="Load in Acars"></i>
              </a>
            @elseif($acars_plugin)
              <a href="vmsacars:flight/{{ $flight->id }}" class="btn btn-sm m-0 mx-1 p-0 px-1 btn-warning">
                <i class="fas fa-file-download" title="Load in Acars"></i>
              </a>
            @endif
            @if(Theme::getSetting('pireps_manual'))
              <a href="{{ route('frontend.pireps.create') }}?flight_id={{ $flight->id }}" class="btn btn-sm btn-info m-0 mx-1 p-0 px-1">
                <i class="fas fa-file-upload" title="@lang('disposable.new_pirep')"></i>
              </a>
            @endif
          @endif
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

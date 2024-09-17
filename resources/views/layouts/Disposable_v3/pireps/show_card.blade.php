<div class="card mb-2">
  <div class="card-header p-1">
    <h5 class="m-1">
      @if(filled($pirep->flight) && !str_contains($pirep->route_code, 'PF'))
        <a href="{{ route('frontend.flights.show', [$pirep->flight_id]) }}"><i class="fas fa-paper-plane mx-1" title="Flight Details"></i></a>
      @endif
      {{ optional($pirep->airline)->code.' '.$pirep->flight_number.' | ' }}
      @if(Theme::getSetting('flights_flags'))
        <img class="img-mh20 mx-1" title="{{ strtoupper(optional($pirep->dpt_airport)->country) }}" src="{{ public_asset('/image/flags_new/'.strtolower(optional($pirep->dpt_airport)->country).'.png') }}" alt=""/>
      @endif
      {{ optional($pirep->dpt_airport)->location.' > '.optional($pirep->arr_airport)->location }}
      @if(Theme::getSetting('flights_flags'))
        <img class="img-mh20 mx-1" title="{{ strtoupper(optional($pirep->arr_airport)->country) }}" src="{{ public_asset('/image/flags_new/'.strtolower(optional($pirep->arr_airport)->country).'.png') }}" alt=""/>
      @endif
      <i class="fas fa-file-upload float-end"></i>
    </h5>
  </div>
  <div class="card-body p-1">
    <div class="row row-cols-md-3">
      <div class="col-md-5 text-start">
          <i class="fas fa-plane-departure m-1"></i>
          <a href="{{ route('frontend.airports.show', [$pirep->dpt_airport_id]) }}">
            {{ optional($pirep->dpt_airport)->full_name ?? $pirep->dpt_airport_id }}
          </a>
      </div>
      <div class="col-md-2 text-center">
        @if(filled($pirep->distance))
          <i class="fas fa-route m-1"></i>
          {{ DT_ConvertDistance($pirep->distance, $units['distance']) }}
        @endif
      </div>
      <div class="col-md-5 text-end">
        <a href="{{ route('frontend.airports.show', [$pirep->arr_airport_id]) }}">
          {{ optional($pirep->arr_airport)->full_name ?? $pirep->arr_airport_id }}
        </a>
        <i class="fas fa-plane-arrival m-1"></i>
      </div>
    </div>
    <div class="row row-cols-md-3">
      <div class="col-md text-start">
        @if(filled($pirep->block_off_time))
          <i class="fas fa-clock float-start m-1" title="Off Block"></i>
          {{ $pirep->block_off_time->format('H:i | l d.M.Y') }}
        @endif
      </div>
      <div class="col-md text-center">
        @if(filled($pirep->flight_time))
          <i class="fas fa-stopwatch m-1" title="Block Time"></i>
          {{ DT_ConvertMinutes($pirep->flight_time, '%2dh %2dm') }}
        @endif
      </div>
      <div class="col-md text-end">
        @if($pirep->block_on_time > $pirep->block_off_time)
          <i class="fas fa-clock float-end m-1" title="On Block"></i>
          {{ $pirep->block_on_time->format('H:i | l d.M.Y') }}
        @endif
      </div>
    </div>
  </div>
  <div class="card-footer bg-transparent p-1">
    <div class="progress" style="height: 20px;">
      <div
        class="progress-bar bg-success @if(blank($pirep->block_on_time)) progress-bar-striped progress-bar-animated @endif text-black"
        role="progressbar" style="width: {{ $pirep->progress_percent }}%;"
        aria-valuenow="{{ $pirep->progress_percent }}" aria-valuemin="0" aria-valuemax="100">
        {{ $pirep->progress_percent }}%
      </div>
    </div>
  </div>
  <div class="card-footer bg-transparent p-1">
    <div class="row row-cols-lg-2">
      <div class="col text-start">
        {!! DT_NetworkPresence($pirep) !!}
        {!! DT_FlightType($pirep->flight_type, 'button') !!}
      </div>
      <div class="col text-end">
        {!! DT_RouteCode($pirep->route_code, 'button') !!} {!! DT_RouteLeg($pirep->route_leg, 'button') !!}
        @ability('admin', 'admin-user')
          @if($DSpecial && filled($pirep->route_code) && filled($pirep->route_leg))
            <a href="{{ route('DSpecial.tour_remove', [$pirep->id]) }}">
              <span class="btn btn-sm bg-danger m-0 mx-1 p-0 px-1"
                onclick="return confirm('Are you really sure ?\nRemoving tour details from the pirep is irreversible !!!')"
                title="Remove Tour details from Pirep !">Remove Tour
              </span>
            </a>
          @endif
        @endability
        @if(!$pirep->read_only && !$pirep->source == 1 && $user && $pirep->user_id === $user->id)
          <form method="get" action="{{ route('frontend.pireps.edit', $pirep->id) }}">
            @csrf
            <button class="btn btn-sm btn-info m-0 mx-1 p-0 px-1">@lang('common.edit')</button>
          </form>
          <form method="post" action="{{ route('frontend.pireps.submit', $pirep->id) }}">
            @csrf
            <button class="btn btn-sm btn-success m-0 mx-1 p-0 px-1">@lang('common.submit')</button>
          </form>
        @endif
      </div>
    </div>
  </div>
</div>
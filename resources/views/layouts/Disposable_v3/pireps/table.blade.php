@php
  $units = isset($units) ? $units : DT_GetUnits();
  $DBasic = isset($DBasic) ? $DBasic : check_module('DisposableBasic');
@endphp
<table class="table table-sm table-borderless table-striped text-nowrap align-middle mb-0">
  <thead>
    <tr>
      <th>@sortablelink('flight_number', __('flights.flightnumber'))</th>
      @if(Theme::getSetting('flights_codeleg'))
        <th>@sortablelink('route_code', __('flights.code'))</th>
        <th>@sortablelink('route_leg', 'Leg')</th>
      @endif
      <th>@sortablelink('dpt_airport_id', __('common.departure'))</th>
      <th>@sortablelink('arr_airport_id', __('common.arrival'))</th>
      <th class="text-center">@sortablelink('aircraft_id', __('common.aircraft'))</th>
      <th class="text-center">@sortablelink('flight_time', __('flights.flighttime'))</th>
      <th class="text-center">@sortablelink('fuel_used', __('disposable.fused'))</th>
      <th class="text-center">@sortablelink('score', __('disposable.score'))</th>
      <th class="text-center">@sortablelink('landing_rate', __('disposable.lrate'))</th>
      <th class="text-end">@sortablelink('submitted_at', __('pireps.submitted'))</th>
      <th class="text-end">@lang('common.status')</th>
    </tr>
  </thead>
  <tbody>
    @foreach($pireps as $pirep)
      <tr>
        <td>
          @if(Theme::getSetting('flights_codeleg'))
            <a href="{{ route('frontend.pireps.show', [$pirep->id]) }}">{{ $pirep->airline->code.' '.$pirep->flight_number }}</a>
          @else
            <a href="{{ route('frontend.pireps.show', [$pirep->id]) }}">{{ $pirep->ident }}</a>
          @endif
        </td>
        @if(Theme::getSetting('flights_codeleg'))
          <td>{{ $pirep->route_code }}</td>
          <td>{{ $pirep->route_leg }}</td>
        @endif
        <td>
          <a href="{{ route('frontend.airports.show', [$pirep->dpt_airport_id]) }}">{{ optional($pirep->dpt_airport)->full_name }}</a>
        </td>
        <td>
          <a href="{{ route('frontend.airports.show', [$pirep->arr_airport_id]) }}">{{ optional($pirep->arr_airport)->full_name }}</a>
        </td>
        <td class="text-center">
          @if($DBasic) <a href="{{ route('DBasic.aircraft', [optional($pirep->aircraft)->registration ?? '-'])}}"> @endif
          {{ optional($pirep->aircraft)->ident ?? '-' }}
          @if($DBasic) </a> @endif
        </td>
        <td class="text-center">
          {{ DT_ConvertMinutes($pirep->flight_time) }}
        </td>
        <td class="text-center">
          {{ DT_ConvertWeight($pirep->fuel_used, $units['fuel']) }}
        </td>
        <td class="text-center">
          {{ $pirep->score }}
        </td>
        <td class="text-center">
          @if(filled($pirep->landing_rate))
            {{ $pirep->landing_rate.' ft/min' }}
          @endif
        </td>
        <td class="text-end">
          @if(filled($pirep->submitted_at))
            {{ $pirep->submitted_at->diffForHumans().' | '.$pirep->submitted_at->format('d.M') }}
          @endif
        </td>
        <td class="text-end">
          @if(!$pirep->read_only && !$pirep->source == 1)
            <a href="{{ route('frontend.pireps.edit', [$pirep->id]) }}" class="btn btn-sm btn-info m-0 mx-1 p-0 px-1">@lang('common.edit')</a>
          @endif
          @if($DBasic && Theme::getSetting('gen_stable_approach'))
            @widget('DBasic::StableApproach', ['pirep' => $pirep])
          @endif
          {!! DT_PirepState($pirep) !!}
          {!! DT_NetworkPresence($pirep) !!}
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
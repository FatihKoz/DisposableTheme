@php 
  $units = isset($units) ? $units : DT_GetUnits();
  $DBasic = isset($DBasic) ? $DBasic : DT_CheckModule('DisposableBasic');
@endphp
<table class="table table-sm table-borderless table-striped text-nowrap align-middle mb-0">
  <thead>
    <tr>
      <th>@lang('flights.flightnumber')</th>
      <th>@lang('common.departure')</th>
      <th>@lang('common.arrival')</th>
      <th class="text-center">@lang('common.aircraft')</th>
      <th class="text-center">@lang('flights.flighttime')</th>
      <th class="text-center">@lang('disposable.fused')</th>
      <th class="text-center">@lang('disposable.score')</th>
      <th class="text-center">@lang('disposable.lrate')</th>
      <th class="text-end">@lang('pireps.submitted')</th>
      <th class="text-end">@lang('common.status')</th>
    </tr>
  </thead>
  <tbody>
    @foreach($pireps as $pirep)
      <tr>
        <td>
          <a href="{{ route('frontend.pireps.show', [$pirep->id]) }}">{{ $pirep->ident }}</a>
        </td>
        <td>
          <a href="{{route('frontend.airports.show', [$pirep->dpt_airport_id])}}">{{ optional($pirep->dpt_airport)->full_name }}</a>
        </td>
        <td>
          <a href="{{route('frontend.airports.show', [$pirep->arr_airport_id])}}">{{ optional($pirep->arr_airport)->full_name }}</a>
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
          @if(!$pirep->read_only)
            <a href="{{ route('frontend.pireps.edit', [$pirep->id]) }}" class="btn btn-sm btn-info m-0 mx-1 p-0 px-1">@lang('common.edit')</a>
          @endif
          @if($pirep->read_only && Theme::getSetting('gen_ivao_vaid') && Theme::getSetting('gen_ivao_icao'))
            @include('pireps.ivao_vasys')
          @endif
          @if($DBasic && Theme::getSetting('gen_stable_approach'))
            @widget('DBasic::StableApproach', ['pirep' => $pirep])
          @endif
          {!! DT_PirepState($pirep) !!}
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
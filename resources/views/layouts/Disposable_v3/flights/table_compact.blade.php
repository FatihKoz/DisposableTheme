<table class="table table-sm table-striped table-borderless text-center align-middle mb-0">
  <thead>
    <tr>
      <th class="text-start">@lang('flights.flightnumber')</th>
      @if(isset($type) && $type === 'arr' || !isset($type))
        <th class="text-start">@lang('airports.departure')</th>
      @endif
      @if(isset($type) && $type === 'dep' || !isset($type))
        <th class="text-start">@lang('airports.arrival')</th>
      @endif
      <th>@lang('flights.dep')</th>
      <th>@lang('flights.arr')</th>
    </tr>
  </thead>
  <tbody>
    @foreach($flights as $flight)
      <tr>
        <td class="text-start">
          <a href="{{ route('frontend.flights.show', [$flight->id]) }}">{{ optional($flight->airline)->code.' '.$flight->flight_number }}</a>
        </td>
        @if(isset($type) && $type === 'arr' || !isset($type))
          <td class="text-start">
            <a href="{{ route('frontend.airports.show',[$flight->dpt_airport_id]) }}">
              {{ $flight->dpt_airport->full_name ?? $flight->dpt_airport_id }}
            </a>
          </td>
        @endif
        @if(isset($type) && $type === 'dep' || !isset($type))
          <td class="text-start">
            <a href="{{ route('frontend.airports.show',[$flight->arr_airport_id]) }}">
              {{ $flight->arr_airport->full_name ?? $flight->arr_airport_id }}
            </a>
          </td>
        @endif
        <td>{{ DT_FormatScheduleTime($flight->dpt_time) }}</td>
        <td>{{ DT_FormatScheduleTime($flight->arr_time) }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
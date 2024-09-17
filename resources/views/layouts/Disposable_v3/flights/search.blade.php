<div class="card mb-2">
  <div class="card-header p-1">
    <h5 class="m-1">
      @lang('flights.search')
      <i class="fas fa-search float-end"></i>
    </h5>
  </div>
  <form method="get" action="{{ route('frontend.flights.search') }}">
    @csrf
    <div class="card-body p-1 form-group">
      <div class="input-group input-group-sm mt-1">
        <span class="input-group-text col-lg-4">@lang('common.airline')</span>
        @php asort($airlines, SORT_NATURAL); @endphp
        <select class="form-control select2" name="airline_id" id="airline_id">
          @foreach($airlines as $airline_id => $airline_label)
            <option value="{{ $airline_id }}" @if(request()->query('airline_id') == $airline_id) selected @endif>{{ $airline_label }}</option>
          @endforeach
        </select>
      </div>
      <div class="input-group input-group-sm mt-1">
        <span class="input-group-text col-lg-4">@lang('flights.flighttype')</span>
        <select class="form-control select2" name="flight_type" id="flight_type">
          @foreach($flight_types as $flight_type_id => $flight_type_label)
            <option value="{{ $flight_type_id }}" @if(request()->query('flight_type') == $flight_type_id) selected @endif>{{ $flight_type_label }}</option>
          @endforeach
        </select>
      </div>
      <div class="input-group input-group-sm mt-1">
        <span class="input-group-text col-lg-4">@lang('flights.flightnumber')</span>
        <input class="form-control" type="number" name="flight_number" id="flight_number" value="{{ request()->query('flight_number') }}" min="0" step="1" />
      </div>
      <div class="input-group input-group-sm mt-1">
        <span class="input-group-text col-lg-4">@lang('flights.callsign')</span>
        <input class="form-control" type="text" name="callsign" id="callsign" value="{{ request()->query('callsign') }}" />
      </div>
      <div class="input-group input-group-sm mt-1">
        <span class="input-group-text col-lg-4">@lang('flights.code')</span>
        <input class="form-control" type="text" name="route_code" id="route_code" value="{{ request()->query('route_code') }}" />
      </div>
      <div class="input-group input-group-sm mt-1">
        <span class="input-group-text col-lg-4">@lang('flights.flighttime')</span>
        <input class="form-control" type="number" name="tgt" id="tgt" value="{{ request()->query('tgt') }}" min="0" step="1" title="Minimum (mins)" />
        <input class="form-control" type="number" name="tlt" id="tlt" value="{{ request()->query('tlt') }}" min="0" step="1" title="Maximum (mins)" />
      </div>
      <div class="input-group input-group-sm mt-1">
        <span class="input-group-text col-lg-4">@lang('common.distance')</span>
        <input class="form-control" type="number" name="dgt" id="dgt" value="{{ request()->query('dgt') }}" min="0" step="1" title="Minimum (nmi)" />
        <input class="form-control" type="number" name="dlt" id="dlt" value="{{ request()->query('dlt') }}" min="0" step="1" title="Maximum (nmi)" />
      </div>
      <div class="input-group input-group-sm mt-1">
        <span class="input-group-text col-lg-4">@lang('airports.departure')</span>
        <select class="form-control airport_search" name="dep_icao" id="dep_icao"></select>
      </div>
      <div class="input-group input-group-sm mt-1">
        <span class="input-group-text col-lg-4">@lang('airports.arrival')</span>
        <select class="form-control airport_search" name="arr_icao" id="arr_icao"></select>
      </div>
      <div class="input-group input-group-sm mt-1">
        <span class="input-group-text col-lg-4">@lang('common.subfleet')</span>
        @php asort($subfleets, SORT_NATURAL); @endphp
        <select class="form-control select2" name="subfleet_id" id="subfleet_id">
          @foreach($subfleets as $subfleet_id => $subfleet_label)
            <option value="{{ $subfleet_id }}" @if(request()->query('subfleet_id') == $subfleet_id) selected @endif>{{ $subfleet_label }}</option>
          @endforeach
        </select>
      </div>
      @if(filled($type_ratings))
        <div class="input-group input-group-sm mt-1">
          <span class="input-group-text col-lg-4">Type Rating</span>
          <select class="form-control select2" name="type_rating_id" id="type_rating_id">
            <option value=""></option>
            @foreach($type_ratings as $tr)
              <option value="{{ $tr->id }}" @if(request()->query('type_rating_id') == $tr->id) selected @endif>{{ $tr->type.' | '.$tr->name }}</option>
            @endforeach
          </select>
        </div>
      @endif
      @if(filled($icao_codes))
        <div class="input-group input-group-sm mt-1">
          <span class="input-group-text col-lg-4">Aircraft ICAO</span>
          <select class="form-control select2" name="icao_type" id="icao_type">
            <option value=""></option>
            @foreach($icao_codes as $icao)
              <option value="{{ $icao }}" @if(request()->query('icao_type') == $icao) selected @endif>{{ $icao }}</option>
            @endforeach
          </select>
        </div>
      @endif
    </div>
    <div class="card-footer bg-transparent p-1 text-end">
      <button class="btn btn-sm btn-primary m-0 mx-1 p-0 px-1" type="submit">@lang('common.find')</button>
      <a class="btn btn-sm btn-secondary m-0 mx-1 p-0 px-1" href="{{ route('frontend.flights.index') }}">@lang('common.reset')</a>
    </div>
  </form>
</div>
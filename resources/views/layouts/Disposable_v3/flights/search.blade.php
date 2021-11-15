<div class="card mb-2">
  <div class="card-header p-1">
    <h5 class="m-1">
      @lang('flights.search')
      <i class="fas fa-search float-end"></i>
    </h5>
  </div>
  {{ Form::open(['route' => 'frontend.flights.search', 'method' => 'GET']) }}
  <div class="card-body p-1">
    <div class="form-group">
      <div class="input-group input-group-sm mt-1">
        <span class="input-group-text col-4">@lang('common.airline')</span>
        {{ Form::select('airline_id', $airlines, null , ['class' => 'form-control select2']) }}
      </div>
      <div class="input-group input-group-sm mt-1">
        <span class="input-group-text col-4">@lang('flights.flighttype')</span>
        {{ Form::select('flight_type', $flight_types, null , ['class' => 'form-control select2']) }}
      </div>
      <div class="input-group input-group-sm mt-1">
        <span class="input-group-text col-4">@lang('flights.flightnumber')</span>
        {{ Form::text('flight_number', null, ['class' => 'form-control']) }}
      </div>
      <div class="input-group input-group-sm mt-1">
        <span class="input-group-text col-4">@lang('flights.callsign')</span>
        {{ Form::text('callsign', null, ['class' => 'form-control']) }}
      </div>
      <div class="input-group input-group-sm mt-1">
        <span class="input-group-text col-4">@lang('flights.code')</span>
        {{ Form::text('route_code', null, ['class' => 'form-control']) }}
      </div>
      <div class="input-group input-group-sm mt-1">
        <span class="input-group-text col-4">@lang('common.distance')</span>
        {{ Form::number('dgt', null, ['class' => 'form-control', 'title' => 'Minimum (nm)']) }}
        {{ Form::number('dlt', null, ['class' => 'form-control', 'title' => 'Maximum (nm)']) }}
      </div>
      <div class="input-group input-group-sm mt-1">
        <span class="input-group-text col-4">@lang('airports.departure')</span>
        {{ Form::select('dep_icao', $airports, null , ['class' => 'form-control select2']) }}
      </div>
      <div class="input-group input-group-sm mt-1">
        <span class="input-group-text col-4">@lang('airports.arrival')</span>
        {{ Form::select('arr_icao', $airports, null , ['class' => 'form-control select2']) }}
      </div>
      <div class="input-group input-group-sm mt-1">
        <span class="input-group-text col-4">@lang('common.subfleet')</span>
        {{ Form::select('subfleet_id', $subfleets, null , ['class' => 'form-control select2']) }}
      </div>
    </div>
  </div>
  <div class="card-footer bg-transparent p-1 text-end">
    {{ Form::submit(__('common.find'), ['class' => 'btn btn-sm btn-primary m-0 mx-1 p-0 px-1']) }}
    <button href="{{ route('frontend.flights.index') }}" class="btn btn-sm btn-secondary m-0 mx-1 p-0 px-1">@lang('common.reset')</button>
  </div>
  {{ Form::close() }}
</div>
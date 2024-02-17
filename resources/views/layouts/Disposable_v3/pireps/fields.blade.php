{{--
NOTE ABOUT THIS VIEW

The fields that are marked "read-only", make sure the read-only status doesn't change!
If you make those fields editable, after they're in a read-only state, it can have
an impact on your stats and financials, and will require a recalculation of all the
flight reports that have been filed. You've been warned!
--}}
@php
  $readonly = (!empty($pirep) && $pirep->read_only) ? 'readonly' : null;
  $select2_readonly = isset($readonly) ? 'disabled' : null;
@endphp
<div class="card-body p-1">
  @if($readonly)
    <div class="row">
      <div class="col">
        @component('components.info')
          @lang('pireps.fieldsreadonly')
        @endcomponent
      </div>
    </div>
  @endif
  <div class="row">
    <div class="col">
      <div class="form-container mb-2">
        <h6 class="m-1">
          <i class="fas fa-info-circle me-1"></i>
          @lang('pireps.flightinformations')
        </h6>
        <div class="form-group">
          {{-- Airline, Flight Ident, Flight Type--}}
          <div class="row row-cols-lg-3 mb-2">
            <div class="col-lg">
              <div class="input-group input-group-sm">
                <input type="hidden" name="airline_id" value="{{ optional($pirep)->airline_id }}" />
                <span class="input-group-text">@lang('common.airline')</span>
                <select class="form-control select2" name="airline_id" id="airline_id" {{ $select2_readonly }}>
                  @foreach($airline_list as $airline_id => $airline_label)
                    <option value="{{ $airline_id }}" @if(!empty($pirep) && $airline_id == $pirep->airline_id) selected @endif>{{ $airline_label }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-lg">
              <div class="input-group input-group-sm">
                <input class="form-control" type="text" name="flight_number" id="flight_number" placeholder="@lang('flights.flightnumber')" value="{{ optional($pirep)->flight_number }}" {{ $readonly }} />
                <input class="form-control" type="text" name="route_code" id="route_code" placeholder="@lang('pireps.codeoptional')" value="{{ optional($pirep)->route_code }}" {{ $readonly }} />
                <input class="form-control" type="text" name="route_leg" id="route_leg" placeholder="@lang('pireps.legoptional')" value="{{ optional($pirep)->route_leg }}" {{ $readonly }} />
              </div>
            </div>
            <div class="col-lg">
              <div class="input-group input-group-sm">
                <input type="hidden" name="flight_type" value="{{ optional($pirep)->flight_type }}" />
                <span class="input-group-text">@lang('flights.flighttype')</span>
                <select class="form-control select2" name="flight_type" id="flight_type" {{ $select2_readonly }}>
                  @foreach(\App\Models\Enums\FlightType::select() as $flight_type_id => $flight_type_label)
                    <option value="{{ $flight_type_id }}" @if(!empty($pirep) && $pirep->flight_type == $flight_type_id) selected @endif>{{ $flight_type_label }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          {{-- Departure & Arrival Airports --}}
          <div class="row row-cols-lg-2 mb-2">
            <div class="col-lg">
              <div class="input-group input-group-sm">
                <input type="hidden" name="dpt_airport_id" value="{{ optional($pirep)->dpt_airport_id }}" />
                <span class="input-group-text">@lang('airports.departure')</span>
                <select class="form-control airport_search" name="dpt_airport_id" id="dpt_airport_id" {{ $select2_readonly }}>
                  @foreach($airport_list as $dpt_airport_id => $dpt_airport_label)
                    <option value="{{ $dpt_airport_id }}" @if(!empty($pirep) && $pirep->dpt_airport_id == $dpt_airport_id) selected @endif>{{ $dpt_airport_label }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-lg">
              <div class="input-group input-group-sm">
                <input type="hidden" name="arr_airport_id" value="{{ optional($pirep)->arr_airport_id }}" />
                <span class="input-group-text" id="arr_airport_id">@lang('airports.arrival')</span>
                <select class="form-control airport_search" name="arr_airport_id" id="arr_airport_id" {{ $select2_readonly }}>
                  @foreach($airport_list as $dpt_airport_id => $dpt_airport_label)
                    <option value="{{ $arr_airport_id }}" @if(!empty($pirep) && $pirep->arr_airport_id == $arr_airport_id) selected @endif>{{ $arr_airport_label }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          {{-- Flight Times, Level, Distance, Fuel Figures --}}
          <div class="row row-cols-lg-5">
            <div class="col-lg">
              <div class="input-group input-group-sm">
                <span class="input-group-text">@lang('flights.flighttime')</span>
                <input class="form-control" type="number" name="hours" id="hours" placeholder="{{ trans_choice('common.hour', 2) }}" min="0" max="24" value="{{ optional($pirep)->hours }}" {{ $readonly }} />
                <input class="form-control" type="number" name="minutes" id="minutes" placeholder="{{ trans_choice('common.minute', 2) }}" min="0" max="59" value="{{ optional($pirep)->minutes }}" {{ $readonly }} />
              </div>
            </div>
            <div class="col-lg">
              <div class="input-group input-group-sm">
                <span class="input-group-text">@lang('flights.level') ({{config('phpvms.internal_units.altitude')}})</span>
                <input class="form-control" type="number" name="level" id="level" min="0" step="500" value="{{ optional($pirep)->level }}" {{ $readonly }} />
              </div>
            </div>
            <div class="col-lg">
              <div class="input-group input-group-sm">
                <span class="input-group-text">@lang('common.distance') ({{ config('phpvms.internal_units.distance') }})</span>
                <input class="form-control" type="number" name="distance" id="distance" min="0" step="0.01" value="{{ optional(optional($pirep)->distance)->internal(2) }}" {{ $readonly }} />
              </div>
            </div>
            <div class="col-lg">
              <div class="input-group input-group-sm">
                <span class="input-group-text">@lang('pireps.block_fuel') ({{ $units['fuel'] }})</span>
                <input class="form-control" type="number" name="block_fuel" id="block_fuel" min="0" step="0.01" value="{{ optional($pirep)->block_fuel }}" {{ $readonly }} />
              </div>
            </div>
            <div class="col-lg">
              <div class="input-group input-group-sm">
                <span class="input-group-text">@lang('pireps.fuel_used') ({{ $units['fuel'] }})</span>
                <input class="form-control" type="number" name="fuel_used" id="fuel_used" min="0" step="0.01" value="{{ optional($pirep)->fuel_used }}" {{ $readonly }} />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="form-container mb-2">
        <h6 class="m-1">
          <i class="fab fa-avianex me-1"></i>
          @lang('pireps.aircraftinformations')
        </h6>
        <div class="form-group">
          <div class="row">
            <div class="col-lg-6">
              <div class="input-group input-group-sm">
                <input type="hidden" name="aircraft_id" value="{{ optional($pirep)->aircraft_id }}" />
                <span class="input-group-text">@lang('common.aircraft')</span>
                {{-- You probably don't want to change this ID if you want the fare select to work --}}
                <select class="form-control select2" name="aircraft_id" id="aircraft_select" {{ $select2_readonly }}>
                  @foreach($aircraft_list as $subfleet => $sf_aircraft)
                    @if ($subfleet === '')
                      <option value=""></option>
                    @else
                      @foreach($sf_aircraft as $aircraft_id => $aircraft_label)
                        <option value="{{ $aircraft_id }}" @if(!empty($pirep) && $pirep->aircraft_id == $aircraft_id) selected @endif>{{ $aircraft_label }}</option>
                      @endforeach
                    @endif
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
      {{-- Fares, if any and loaded when an aircraft is selected --}}
      <div class="form-container mb-2" id="fares_container">
        @include('pireps.fares')
      </div>
      {{-- Route --}}
      <div class="form-container mb-2">
        <h6 class="m-1">
          <i class="fas fa-route me-1"></i>
          @lang('flights.route')
        </h6>
        <div class="form-group">
          <div class="row">
            <div class="col">
              <div class="input-group input-group-sm">
                <textarea class="form-control" name="route" id="route" rows="3" {{ $readonly }}>{{ optional($pirep)->route }}</textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
      {{-- Notes / Remarks --}}
      <div class="form-container mb-2">
        <h6 class="m-1">
          <i class="far fa-comments me-1"></i>
          {{ trans_choice('common.remark', 2).' / '.trans_choice('common.note', 2) }}
        </h6>
        <div class="form-group">
          <div class="row">
            <div class="col">
              <div class="input-group input-group-sm">
                <textarea class="form-control" name="notes" id="notes" rows="3">{{ optional($pirep)->notes }}</textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{-- Custom Pirep Fields --}}
    @if($pirep_fields && count($pirep_fields) > 0)
      <div class="col-3">
        <div class="form-container">
          <h6 class="m-1">
            <i class="fas fa-th-list me-1"></i>
            {{ trans_choice('common.field', 2) }}
          </h6>
          <div class="form-group">
            <table class="table table-sm table-borderless align-middle mb-0">
              @if(isset($pirep) && $pirep->fields)
                @each('pireps.custom_fields', $pirep->fields, 'field')
              @else
                @each('pireps.custom_fields', $pirep_fields, 'field')
              @endif
            </table>
          </div>
        </div>
      </div>
    @endif
  </div>
</div>
{{-- Validation Results --}}
@if($errors->any())
<div class="card-footer p-1">
  {!! implode('', $errors->all('<div class="alert alert-danger mb-1 p-1 px-2 fw-bold">:message</div>')) !!}
</div>
@endif
{{-- Form Actions --}}
<div class="card-footer p-1 text-end">
  <div class="form-group">
    <input type="hidden" name="flight_id" value="{{ optional($pirep)->flight_id }}" />
    <input type="hidden" name="sb_id" value="{{ $simbrief_id }}" />
    @if(isset($pirep) && !$pirep->read_only)
      <button class="btn btn-sm btn-warning m-0 mx-1 p-0 px-1" type="submit" name="submit" value="Delete" onclick="return confirm('Are you sure ?')">{{ __('pireps.deletepirep') }}</button>
    @endif
    <button class="btn btn-sm btn-info m-0 mx-1 p-0 px-1" type="submit" name="submit" value="Save">{{ __('pireps.savepirep') }}</button>
    @if(!isset($pirep) || (filled($pirep) && !$pirep->read_only))
      <button class="btn btn-sm btn-success m-0 mx-1 p-0 px-1" type="submit" name="submit" value="Submit">{{ __('pireps.submitpirep') }}</button>
    @endif
  </div>
</div>
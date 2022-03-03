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
              @if($readonly)
                {{ Form::hidden('airline_id') }}
              @endif
              <div class="input-group input-group-sm">
                <span class="input-group-text" id="airline_id">@lang('common.airline')</span>
                {{ Form::select('airline_id', $airline_list, null, ['class' => 'form-control select2', $select2_readonly]) }}
              </div>
            </div>
            <div class="col-lg">
              <div class="input-group input-group-sm">
                {{ Form::text('flight_number', null, ['placeholder' => __('flights.flightnumber'), 'class' => 'form-control', $readonly]) }}
                {{ Form::text('route_code', null, ['placeholder' => __('pireps.codeoptional'), 'class' => 'form-control', $readonly]) }}
                {{ Form::text('route_leg', null, ['placeholder' => __('pireps.legoptional'), 'class' => 'form-control', $readonly]) }}
              </div>
            </div>
            <div class="col-lg">
              @if($readonly)
                {{ Form::hidden('flight_type') }}
              @endif
              <div class="input-group input-group-sm">
                <span class="input-group-text" id="flight_type">@lang('flights.flighttype')</span>
                {{ Form::select('flight_type', \App\Models\Enums\FlightType::select(), null, ['class' => 'form-control select2', $select2_readonly]) }}
              </div>
            </div>
          </div>
          {{-- Departure & Arrival Airports --}}
          <div class="row row-cols-lg-2 mb-2">
            <div class="col-lg">
              @if($readonly)
                {{ Form::hidden('dpt_airport_id') }}
              @endif
              <div class="input-group input-group-sm">
                <span class="input-group-text" id="dpt_airport_id">@lang('airports.departure')</span>
                {{ Form::select('dpt_airport_id', $airport_list, null, ['class' => 'form-control select2', $select2_readonly]) }}
              </div>
            </div>
            <div class="col-lg">
              @if($readonly)
                {{ Form::hidden('arr_airport_id') }}
              @endif
              <div class="input-group input-group-sm">
                <span class="input-group-text" id="arr_airport_id">@lang('airports.arrival')</span>
                {{ Form::select('arr_airport_id', $airport_list, null, ['class' => 'form-control select2', $select2_readonly]) }}
              </div>
            </div>
          </div>
          {{-- Flight Times, Level, Distance, Fuel Figures --}}
          <div class="row row-cols-lg-5">
            <div class="col-lg">
              <div class="input-group input-group-sm">
                <span class="input-group-text">@lang('flights.flighttime')</span>
                {{ Form::number('hours', null, ['class' => 'form-control', 'placeholder' => trans_choice('common.hour', 2), 'min' => '0', $readonly]) }}
                {{ Form::number('minutes', null, ['class' => 'form-control', 'placeholder' => trans_choice('common.minute', 2), 'min' => 0, 'max' => 59, $readonly]) }}
              </div>
            </div>
            <div class="col-lg">
              <div class="input-group input-group-sm">
                <span class="input-group-text">@lang('flights.level') ({{config('phpvms.internal_units.altitude')}})</span>
                {{ Form::number('level', null, ['class' => 'form-control', 'min' => '0', 'step' => '500', $readonly]) }}
              </div>
            </div>
            <div class="col-lg">
              <div class="input-group input-group-sm">
                <span class="input-group-text">@lang('common.distance') ({{config('phpvms.internal_units.distance')}})</span>
                {{ Form::number('distance', null, ['class' => 'form-control', 'min' => '0', 'step' => '0.01', $readonly]) }}
              </div>
            </div>
            <div class="col-lg">
              <div class="input-group input-group-sm">
                <span class="input-group-text">@lang('pireps.block_fuel') ({{ $units['fuel'] }})</span>
                {{ Form::number('block_fuel', null, ['class' => 'form-control', 'min' => '0', 'step' => '0.01', $readonly]) }}
              </div>
            </div>
            <div class="col-lg">
              <div class="input-group input-group-sm">
                <span class="input-group-text">@lang('pireps.fuel_used') ({{ $units['fuel'] }})</span>
                {{ Form::number('fuel_used', null, ['class' => 'form-control', 'min' => '0', 'step' => '0.01', $readonly]) }}
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
              @if($readonly)
                {{ Form::hidden('aircraft_id') }}
              @endif
              <div class="input-group input-group-sm">
                <span class="input-group-text">@lang('common.aircraft')</span>
                {{-- You probably don't want to change this ID if you want the fare select to work --}}
                {{ Form::select('aircraft_id', $aircraft_list, null, ['id' => 'aircraft_select', 'class' => 'form-control select2', $select2_readonly]) }}
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
                {{ Form::textarea('route', null, ['class' => 'form-control', 'placeholder' => __('flights.route'), 'rows' => 3, $readonly]) }}
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
                {{ Form::textarea('notes', null, ['class' => 'form-control', 'placeholder' => trans_choice('common.note', 2), 'rows' => 3]) }}
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
    {{ Form::hidden('flight_id') }}
    {{ Form::hidden('sb_id', $simbrief_id) }}
    @if(isset($pirep) && !$pirep->read_only)
      {{ Form::button(__('pireps.deletepirep'), ['name' => 'submit', 'value' => 'Delete', 'class' => 'btn btn-sm btn-warning m-0 mx-1 p-0 px-1', 'type' => 'submit', 'onclick' => "return confirm('Are you sure ?')"]) }}
    @endif
    {{ Form::button(__('pireps.savepirep'), ['name' => 'submit', 'value' => 'Save', 'class' => 'btn btn-sm btn-info m-0 mx-1 p-0 px-1', 'type' => 'submit']) }}
    @if(!isset($pirep) || (filled($pirep) && !$pirep->read_only))
      {{ Form::button(__('pireps.submitpirep'), ['name' => 'submit', 'value' => 'Submit', 'class' => 'btn btn-sm btn-success m-0 mx-1 p-0 px-1', 'type' => 'submit']) }}
    @endif
  </div>
</div>
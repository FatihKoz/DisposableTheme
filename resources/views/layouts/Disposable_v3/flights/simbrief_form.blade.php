@extends('app')
@section('title', 'SimBrief Flight Planning')
@include('theme_helpers')
@php
  $units = isset($units) ? $units : DT_GetUnits();
  $DBasic = isset($DBasic) ? $DBasic : DT_CheckModule('DisposableBasic');
  $Addon_Specs = ($DBasic && Theme::getSetting('simbrief_specs')) ? DB_GetSpecs($aircraft, true) : null;
  $Check_SSL = str_contains(url()->current(), 'https://');
@endphp
@section('content')
  <form id="sbapiform">
    <div class="row">
      <div class="col-lg-8">
        {{-- Aircraft --}}
        <div class="card mb-2">
          <div class="card-header p-1">
            <h5 class="m-1">
              @lang('common.aircraft') > {{ $aircraft->ident }}
              <i class="fas fa-plane float-end"></i>
            </h5>
          </div>
          <div class="card-body p-1">
            <div class="row mb-1">
              <div class="col-md-4 col-lg-3">
                <div class="input-group input-group-sm">
                  <span class="input-group-text">AC</span>
                  <input type="text" class="form-control" value="{{ $aircraft->registration }} @if($aircraft->registration != $aircraft->name){{ ' `'.$aircraft->name.'`' }}@endif" disabled>
                </div>
                <input type="hidden" name="reg" value="{{ $aircraft->registration }}">
              </div>
              <div class="col-md-4 col-lg-2">
                <div class="input-group input-group-sm">
                  <span class="input-group-text">ICAO</span>
                  <input type="text" class="form-control" value="{{ $aircraft->icao }}" disabled/>
                </div>
                <input type="hidden" id="type" name="type" value="{{ optional($aircraft->subfleet)->simbrief_type ?? $aircraft->icao }}">
              </div>
              @if($aircraft->fuel_onboard->local() > 0)
                <div class="col-md-4 col-lg-2">
                  <div class="input-group input-group-sm">
                    <span class="input-group-text"><i class="fas fa-gas-pump" title="Fuel On Board"></i></span>
                    <input type="text" class="form-control" value="{{ DT_ConvertWeight($aircraft->fuel_onboard, $units['fuel']) }}" disabled>
                  </div>
                </div>
              @endif
              @if($Addon_Specs)
                <div class="col-lg">
                  <div class="input-group input-group-sm">
                    <span class="input-group-text">Addon Specs</span>
                    <select id="addon" class="form-control" onchange="ChangeSpecs()">
                      <option value="0" selected>SimBrief Defaults</option>
                      @foreach($Addon_Specs as $sp)
                        <option value="{{ $sp->simbrief }}">{{ $sp->saircraft }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              @endif
            </div>
            @if($Addon_Specs)
              <div id="specs" class="row row-cols-md-2 row-cols-lg-5 my-1">
                <div class="col">
                  <div class="input-group input-group-sm">
                    <span class="input-group-text">DOW</span>
                    <input id="dow" type="text" class="form-control text-right" value="--" disabled/>
                    <span class="input-group-text input-group-text-prepend">{{ $units['weight'] }}</span>
                  </div>
                </div>
                <div class="col">
                  <div class="input-group input-group-sm">
                    <span class="input-group-text">MZFW</span>
                    <input id="mzfw" type="text" class="form-control text-right" value="--" disabled/>
                    <span class="input-group-text input-group-text-prepend">{{ $units['weight'] }}</span>
                  </div>
                </div>
                <div class="col">
                  <div class="input-group input-group-sm">
                    <span class="input-group-text">MTOW</span>
                    <input id="mtow" type="text" class="form-control text-right" value="--" disabled/>
                    <span class="input-group-text input-group-text-prepend">{{ $units['weight'] }}</span>
                  </div>
                </div>
                <div class="col">
                  <div class="input-group input-group-sm">
                    <span class="input-group-text">MLW</span>
                    <input id="mlw" type="text" class="form-control text-right" value="--" disabled/>
                    <span class="input-group-text input-group-text-prepend">{{ $units['weight'] }}</span>
                  </div>
                </div>
                <div class="col">
                  <div class="input-group input-group-sm">
                    <span class="input-group-text">Fuel Cap</span>
                    <input id="maxfuel" type="text" class="form-control text-right" value="--" disabled/>
                    <span class="input-group-text input-group-text-prepend">{{ $units['fuel'] }}</span>
                  </div>
                </div>
              </div>
            @endif
          </div>
        </div>
        <div class="card mb-2">
          <div class="card-header p-1">
            <h5 class="m-1">
              {{ trans_choice('common.flight', 1).' > '.optional($flight->airline)->code.' '.$flight->flight_number.' | '.DT_FlightType($flight->flight_type, 'text') }}</b>
              <i class="fas fa-paper-plane float-end"></i>
            </h5>
          </div>
          <div class="card-body p-1">
            <div class="row mb-1">
              <div class="col-lg-4">
                <input name="orig" type="hidden" value="{{ $flight->dpt_airport_id }}">
                <div class="input-group input-group-sm">
                  @if(!Theme::getSetting('simbrief_taxitimes'))
                    <span class="input-group-text"><i class="fas fa-plane-departure" title="Departure"></i></span>
                  @endif
                  <input id="dorig" type="text" class="form-control" value="{{ $flight->dpt_airport_id }}" disabled>
                  @if($DBasic && Theme::getSetting('simbrief_runways'))
                    <span class="input-group-text"><i class="fas fa-road" title="Departure Runway"></i></span>
                    <div class="input-group-append">
                      <select name="origrwy" class="form-control form-control-sm">
                        <option value="">AUTO</option>
                        @foreach(DB_GetRunways($flight->dpt_airport_id) as $dep_runway)
                          <option value="{{ $dep_runway->runway_ident }}">{!! $dep_runway->ident !!}</option>
                        @endforeach
                      </select>
                    </div>
                  @endif
                  @if($DBasic && Theme::getSetting('simbrief_taxitimes'))
                    <span class="input-group-text"><i class="fas fa-clock" title="Departure Taxi Time"></i></span>
                    <select id="taxiout" name="taxiout" class="form-control form-control-sm">
                      @for ($i = 1; $i < 30; $i++)
                        <option value="{{ $i }}" @if($i == DB_AvgTaxiTime($flight->dpt_airport_id, 'out', 10)) selected @endif>{{ $i }} min</option>
                      @endfor
                    </select>
                  @endif
                </div>
              </div>
              <div class="col-lg-4">
                <input name="dest" type="hidden" value="{{ $flight->arr_airport_id }}">
                <div class="input-group input-group-sm">
                  @if(!Theme::getSetting('simbrief_taxitimes'))
                    <span class="input-group-text"><i class="fas fa-plane-arrival" title="Arrival"></i></span>
                  @endif
                  <input id="ddest" type="text" class="form-control" value="{{ $flight->arr_airport_id }}" disabled>
                  @if($DBasic && Theme::getSetting('simbrief_runways'))
                    <span class="input-group-text"><i class="fas fa-road" title="Arrival Runway"></i></span>
                    <div class="input-group-append">
                      <select name="destrwy" class="form-control form-control-sm">
                        <option value="">AUTO</option>
                        @foreach(DB_GetRunways($flight->arr_airport_id) as $arr_runway)
                          <option value="{{ $arr_runway->runway_ident }}">{!! $arr_runway->ident !!}</option>
                        @endforeach
                      </select>
                    </div>
                  @endif
                  @if($DBasic && Theme::getSetting('simbrief_taxitimes'))
                    <span class="input-group-text"><i class="fas fa-clock" title="Arrival Taxi Time"></i></span>
                    <select id="taxiin" name="taxiin" class="form-control form-control-sm">
                      @for ($i = 1; $i < 30; $i++)
                        <option value="{{ $i }}" @if($i == DB_AvgTaxiTime($flight->arr_airport_id, 'in', 5)) selected @endif>{{ $i }} min</option>
                      @endfor
                    </select>
                  @endif
                </div>
              </div>
              <div class="col-md-6 col-lg-2">
                <div class="input-group input-group-sm">
                  <span class="input-group-text">ALTN</span>
                  <input name="altn" type="text" class="form-control" maxlength="4" value="{{ $flight->alt_airport_id ?? 'AUTO' }}">
                </div>
              </div>
              <div class="col-md-6 col-lg-2">
                <div class="input-group input-group-sm">
                  <span class="input-group-text">LVL</span>
                  <input id="fl" name="fl" type="number" class="form-control" min="0" max="99600" step="500" value="{{ $flight->level }}" onchange="CheckFL()">
                </div>
              </div>
            </div>

            <div class="row mb-1">
              <div class="col">
                <div class="input-group input-group-sm">
                  <span class="input-group-text"><i class="fas fa-route" title="Route"></i></span>
                  <input name="route" type="text" class="form-control" value="{{ $flight->route }}">
                  @if(Theme::getSetting('simbrief_rfinder'))
                    @if($Check_SSL)
                      <a href="http://rfinder.asalink.net/free" target="_blank" class="btn btn-sm btn-secondary">RouteFinder</a>
                    @else
                      <button id="RouteFinder" type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#rfinderModal" onclick="OpenRouteFinder()">RouteFinder</button>
                    @endif
                  @endif
                </div>
              </div>
            </div>

            <div class="row row-cols-lg-4 mb-1">
              <div class="col-md-4 col-lg">
                <div class="input-group input-group-sm">
                  <span class="input-group-text"><i class="fas fa-calendar-day" title="Date Of Flight"></i></span>
                  <input id="dof" type="text" class="form-control" disabled>
                </div>
              </div>
              <div class="col-6 col-md-4 col-lg">
                @if($flight->dpt_time)
                  <div class="input-group input-group-sm">
                    <span class="input-group-text"><i class="fas fa-plane-departure" title="Scheduled Departure Time"></i></span>
                    <input type="text" class="form-control" value="{{ DT_FormatScheduleTime($flight->dpt_time) }}" disabled>
                  </div>
                @endif
              </div>
              <div class="col-6 col-md-4 col-lg">
                @if($flight->arr_time)
                  <div class="input-group input-group-sm">
                    <span class="input-group-text"><i class="fas fa-plane-arrival" title="Scheduled Arrival Time"></i></span>
                    <input type="text" class="form-control" value="{{ DT_FormatScheduleTime($flight->arr_time) }}" disabled>
                  </div>
                @endif
              </div>
              <div class="col-6 col-md-4 col-lg">
                <div class="input-group input-group-sm">
                  <span class="input-group-text"><i class="fas fa-clock" title="Estimated Departure Time"></i></span>
                  <input id="deph" name="deph" type="number" class="form-control text-center" min="0" max="23" maxlength="2">
                  <span class="input-group-text px-1">:</span>
                  <input id="depm" name="depm" type="number" class="form-control text-center" min="0" max="59" maxlength="2">
                </div>
              </div>
            </div>
          </div>
        </div>
        {{-- Load and Balance --}}
        <div class="card mb-2">
          <div class="card-header p-1">
            <h5 class="m-1">
              Load > {{ $aircraft->registration.' | '.optional($aircraft->airline)->name.' | '.optional($aircraft->subfleet)->name }}
              <i class="fas fa-balance-scale float-end"></i>
            </h5>
          </div>
          <div class="card-body p-1">
            <div class="row row-cols-lg-4 mb-1">
              {{-- Pax Fares --}}
                @foreach($pax_load_sheet as $pfare)
                  <div class="col">
                    <div class="input-group input-group-sm">
                      <span class="input-group-text">{{ $pfare['name'] }}</span>
                      <input id="LoadFare{{ $pfare['id'] }}" type="text" class="form-control" value="{{ $pfare['count'] }}" disabled>
                      <span class="input-group-text">Max: {{ $pfare['capacity'] }}</span>
                    </div>
                  </div>
                @endforeach
              {{-- Cargo Fares --}}
                @foreach($cargo_load_sheet as $cfare)
                  <div class="col">
                    <div class="input-group input-group-sm">
                      <span class="input-group-text">{{ $cfare['name'] }}</span>
                      <input id="LoadFare{{ $cfare['id'] }}" type="text" class="form-control" value="{{ number_format($cfare['count']).' '.$units['weight'] }}" disabled>
                      <span class="input-group-text">@if($tbagload > 0) Avail: @else Max: @endif {{ number_format($cfare['capacity'] - $tbagload).' '.$units['weight'] }}</span>
                    </div>
                  </div>
                @endforeach
            </div>
            @if(isset($tpayload) && $tpayload > 0)
              {{-- Display The Weights Generated --}}
              <div class="row row-cols-lg-4 mb-1">
                @if($tpaxload)
                  <div class="col">
                    <div class="input-group input-group-sm">
                      <span class="input-group-text"><i class="fas fa-users" title="Passenger Weight"></i></span>
                      <input id="tdPaxLoad" type="text" class="form-control" value="{{ number_format($tpaxload).' '.$units['weight'] }}" disabled>
                    </div>
                  </div>
                  <div class="col">
                    <div class="input-group input-group-sm">
                      <span class="input-group-text"><i class="fas fa-suitcase" title="Baggage Weight"></i></span>
                      <input id="tdBagLoad" type="text" class="form-control" value="{{ number_format($tbagload).' '.$units['weight'] }}" disabled>
                    </div>
                  </div>
                @endif
                @if($tpaxload && $tcargoload)
                  <div class="col">
                    <div class="input-group input-group-sm">
                      <span class="input-group-text"><i class="fas fa-dolly-flatbed" title="Cargo Weight"></i></span>
                      <input id="tdCargoLoad" type="text" class="form-control" value="{{ number_format($tcargoload).' '.$units['weight'] }}" disabled>
                    </div>
                  </div>
                @endif
                <div class="col">
                  <div class="input-group input-group-sm">
                    <span class="input-group-text">TRAFFIC LOAD</span>
                    <input id="tdPayload" type="text" class="form-control" value="{{ number_format($tpayload).' '.$units['weight'] }}" disabled>
                  </div>
                </div>
              </div>
            @endif
          </div>
        </div>
        @if(Theme::getSetting('simbrief_raw_wx'))
          <div class="row row-cols-md-2">
            <div class="col-lg">@widget('Weather', ['icao' => $flight->dpt_airport_id, 'raw_only' => true])</div>
            <div class="col-lg">@widget('Weather', ['icao' => $flight->arr_airport_id, 'raw_only' => true])</div>
          </div>
        @endif
      </div>

      <div class="col-lg-4">
        @include('flights.simbrief_form_planning_options')
        @include('flights.simbrief_form_briefing_options')
        @if(Theme::getSetting('simbrief_extrafuel'))
          <div class="card mb-2">
            <div class="card-header p-1">
              <h5 class="m-1">
                Extra Fuel
                <i class="fas fa-gas-pump float-end"></i>
              </h5>
            </div>
            <div class="card-body p-1">
              <div class="input-group input-group-sm">
                <span class="input-group-text col-md-4">@if($units['fuel'] === 'kg') Metric @else Imperial @endif Tonnes</span>
                <input id="addedfuel" name="addedfuel" type="number" class="form-control form-control-sm" placeholder="0.0" min="0" max="60" step="0.1"/>
                @if(Theme::getSetting('simbrief_tankering'))
                  <span class="input-group-text input-group-text-append">{!! DT_CheckTankering($flight, $aircraft) !!}</span>
                @endif
              </div>
              <input type='hidden' name="addedfuel_units" value="wgt">
            </div>
          </div>
        @endif

        {{-- Prepare rest of the Form fields for SimBrief --}}
        @php
          // Get RVR and Remark Text from Theme Settings with some failsafe defaults,
          // Below two variables are also used when DisposableTech module is installed and activated.
          $sb_rvr = filled(Theme::getSetting('simbrief_rvr')) ? Theme::getSetting('simbrief_rvr') : '500';
          $sb_rmk = filled(Theme::getSetting('simbrief_rmk')) ? Theme::getSetting('simbrief_rmk') : strtoupper(config('app.name'));
        @endphp
          {{-- If Disposable Basic Module is installed and activated, Specs will overwrite below two form fields according to your defined specifications and pilot selections --}}
          {{-- Below value fields are just defaults and should remain in the form --}}
          <input type="hidden" id="acdata" name="acdata" value="{'extrarmk':'RVR/{{ $sb_rvr }} RMK/TCAS {{ $sb_rmk }}','paxwgt':{{ round($pax_weight + $bag_weight) }}}" readonly>
          <input type="hidden" id="fuelfactor" name="fuelfactor" value="" readonly>
          @if($tpaxfig)
            <input type="hidden" name="pax" value="{{ $tpaxfig }}">
          @elseif(!$tpaxfig && $tcargoload)
            <input type="hidden" name="pax" value="0">
          @endif
          @if($tcargoload)
            <input type='hidden' id='cargo' name='cargo' value="{{ number_format(($tcargoload / 1000),1) }}">
          @endif
          @if(isset($tpayload) && $tpayload > 0)
            <input type="hidden" name="manualrmk" value="Load Distribution {{ $loaddist }}">
          @endif
          <input type="hidden" name="airline" value="{{ optional($flight->airline)->icao }}">
          <input type="hidden" name="fltnum" value="{{ $flight->flight_number }}">
          @if(setting('simbrief.callsign', false))
            <input type="hidden" name="callsign" value="{{ $user->ident }}">
          @elseif(filled($flight->callsign))
            <input type="hidden" name="callsign" value="{{ optional($flight->airline)->icao.$flight->callsign }}">
          @endif
          @if(setting('simbrief.name_private', false))
            <input type="hidden" name="cpt" value="{{ $user->name_private }}">
          @endif
          <input type="hidden" id="steh" name="steh" maxlength="2">
          <input type="hidden" id="stem" name="stem" maxlength="2">
          <input type="hidden" id="date" name="date" maxlength="9">
          <input type="hidden" id="selcal" name="selcal" value="DS-HR">
          <input type="hidden" id="omit_sids" name="omit_sids" value="0">
          <input type="hidden" id="omit_stars" name="omit_stars" value="0">
          <input type="hidden" id="find_sidstar" name="find_sidstar" value="R">
          <input type="hidden" id="static_id" name="static_id" value="{{ $static_id }}">
        {{-- For more info about form fields and their details check SimBrief / API Support --}}

        <div class="card bg-transparent mb-2 p-0 text-right border-0">
          <input type="button" class="btn btn-sm btn-primary" value="Generate SimBrief OFP"
              onclick="simbriefsubmit('{{ $flight->id }}', '{{ $aircraft->id }}', '{{ url(route('frontend.simbrief.briefing', [''])) }}');">
        </div>
      </div>
    </div>
  </form>

@if(Theme::getSetting('simbrief_rfinder') && !$Check_SSL)
  @include('flights.simbrief_form_routefinder')
@endif

@endsection
@include('flights.simbrief_scripts')

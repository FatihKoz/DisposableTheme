@extends('app')
@section('title', 'SimBrief Flight Planning')
@include('theme_helpers')
@php
  $units = isset($units) ? $units : DT_GetUnits();
  $DBasic = isset($DBasic) ? $DBasic : check_module('DisposableBasic');
  $DSpecial = isset($DSpecial) ? $DSpecial : check_module('DisposableSpecial');
  $Addon_Specs = ($DBasic && Theme::getSetting('simbrief_specs')) ? DB_GetSpecs($aircraft, true) : null;
  $Check_SSL = str_contains(url()->current(), 'https://');
  // Get RVR and Remark Text from Theme Settings with some failsafe defaults,
  // Below variables are also used when DisposableTech module is installed and activated.
  $acdata = str_replace(['{', '}'], '', $acdata);
  $sb_rvr = filled(Theme::getSetting('simbrief_rvr')) ? 'RVR/'.Theme::getSetting('simbrief_rvr') : 'RVR/550';
  $sb_callsign = filled(optional($flight->airline)->callsign) ? ' CS/'.strtoupper($flight->airline->callsign) : null;
  $sb_ivaova = filled(Theme::getSetting('gen_ivao_icao')) ? ' IVAOVA/'.strtoupper(Theme::getSetting('gen_ivao_icao')) : null;
  $sb_rmk = filled(Theme::getSetting('simbrief_rmk')) ? ' RMK/TCAS '.strtoupper(Theme::getSetting('simbrief_rmk')) : ' RMK/TCAS '.strtoupper(config('app.name'));
  if($DSpecial) {
    $sb_rmk = $sb_rmk.' '.DS_GetTourFPLRemark($flight->route_code);
  }
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
                <input type="hidden" id="actype" name="type" value="{{ $actype }}">
              </div>
              @if($aircraft->fuel_onboard->local() > 0)
                <div class="col-md-4 col-lg-2">
                  <div class="input-group input-group-sm">
                    <span class="input-group-text"><i class="fas fa-gas-pump" title="Fuel On Board"></i></span>
                    <input type="text" class="form-control" value="{{ DT_ConvertWeight($aircraft->fuel_onboard, $units['fuel']) }}" disabled>
                  </div>
                </div>
              @endif
              @if($sbairframes)
                <div class="col-lg">
                  <div class="input-group input-group-sm">
                    <span class="input-group-text">SB Airframes</span>
                    <select id="sbairframe" class="form-select" onchange="CheckAirframe()">
                      <option value="" selected>Select an airframe if required...</option>
                      @foreach($sbairframes as $af)
                        <option value="{{ $af->airframe_id }}">@if($af->name == 'Default') SimBrief @endif{{ $af->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              @endif
            </div>
            <div id="specs" class="row row-cols-md-2 row-cols-lg-6 my-1">
              <div class="col-md">
                <div class="input-group input-group-sm">
                  <span class="input-group-text">MZFW</span>
                  <input id="mzfw" type="text" class="form-control text-right" value="{{ $aircraft->zfw->local(0) }}" disabled/>
                  <span class="input-group-text input-group-text-prepend">{{ $units['weight'] }}</span>
                </div>
              </div>
              <div class="col-md">
                <div class="input-group input-group-sm">
                  <span class="input-group-text">MTOW</span>
                  <input id="mtow" type="text" class="form-control text-right" value="{{ $aircraft->mtow->local(0) }}" disabled/>
                  <span class="input-group-text input-group-text-prepend">{{ $units['weight'] }}</span>
                </div>
              </div>
              <div class="col-md">
                <div class="input-group input-group-sm">
                  <span class="input-group-text">MLW</span>
                  <input id="mlw" type="text" class="form-control text-right" value="{{ $aircraft->mlw->local(0) }}" disabled/>
                  <span class="input-group-text input-group-text-prepend">{{ $units['weight'] }}</span>
                </div>
              </div>
              <div class="col-md">
                <div class="input-group input-group-sm">
                  <span class="input-group-text">MSN/FIN</span>
                  <input id="maxfuel" type="text" class="form-control text-right" value="{{ $aircraft->fin }}" disabled/>
                </div>
              </div>
              <div class="col-md">
                <div class="input-group input-group-sm">
                  <span class="input-group-text">HEX</span>
                  <input id="maxfuel" type="text" class="form-control text-right" value="{{ $aircraft->hex_code }}" disabled/>
                </div>
              </div>
              <div class="col-md">
                <div class="input-group input-group-sm">
                  <span class="input-group-text">SELCAL</span>
                  <input id="selcaldisplay" type="text" class="form-control text-right" value="{{ $aircraft->selcal }}" disabled/>
                </div>
              </div>
            </div>
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
                <input name="orig" type="hidden" value="{{ DT_AirportCode($flight->dpt_airport) ?? $flight->dpt_airport_id }}">
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
                <input name="dest" type="hidden" value="{{ DT_AirportCode($flight->arr_airport) ?? $flight->arr_airport_id }}">
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
                  <input name="altn" type="text" class="form-control" maxlength="4" value="{{ DT_AirportCode($flight->alt_airport) ?? 'AUTO' }}">
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
                  <input id="deph" name="deph" type="number" class="form-control text-center" min="0" max="23" maxlength="2" onchange="CheckDOF()">
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
              Estimated Load > {{ $aircraft->registration.' | '.optional($aircraft->airline)->name.' | '.optional($aircraft->subfleet)->name }}
              <i class="fas fa-balance-scale float-end"></i>
            </h5>
          </div>
          <div class="card-body p-1">
            <div class="row row-cols-md-2 row-cols-lg-5 mb-1">
              {{-- Pax Fares --}}
                @foreach($pax_load_sheet as $pfare)
                  <div class="col-md">
                    <div class="input-group input-group-sm">
                      <span class="input-group-text">{{ $pfare['name'] }}</span>
                      <input id="LoadFare{{ $pfare['id'] }}" type="text" class="form-control" value="{{ $pfare['count'] }}" disabled>
                      <span class="input-group-text">Max: {{ $pfare['capacity'] }}</span>
                    </div>
                  </div>
                @endforeach
              {{-- Cargo Fares --}}
                @foreach($cargo_load_sheet as $cfare)
                  <div class="col-md">
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
              <div class="row row-cols-md-2 row-cols-lg-5 mb-1">
                @if($tpaxload)
                  <div class="col-md">
                    <div class="input-group input-group-sm">
                      <span class="input-group-text"><i class="fas fa-users" title="Passenger Weight"></i></span>
                      <input id="tdPaxLoad" type="text" class="form-control" value="{{ number_format($tpaxload).' '.$units['weight'] }}" disabled>
                    </div>
                  </div>
                  <div class="col-md">
                    <div class="input-group input-group-sm">
                      <span class="input-group-text"><i class="fas fa-suitcase" title="Baggage Weight"></i></span>
                      <input id="tdBagLoad" type="text" class="form-control" value="{{ number_format($tbagload).' '.$units['weight'] }}" disabled>
                    </div>
                  </div>
                @endif
                @if($tpaxload && $tcargoload)
                  <div class="col-md">
                    <div class="input-group input-group-sm">
                      <span class="input-group-text"><i class="fas fa-dolly-flatbed" title="Cargo Weight"></i></span>
                      <input id="tdCargoLoad" type="text" class="form-control" value="{{ number_format($tcargoload).' '.$units['weight'] }}" disabled>
                    </div>
                  </div>
                  <div class="col-md">
                    <div class="input-group input-group-sm">
                      <span class="input-group-text" title="Baggage + Cargo Weight"><i class="fas fa-suitcase me-1"></i><i class="fas fa-dolly-flatbed"></i></span>
                      <input id="tdHoldLoad" type="text" class="form-control" value="{{ number_format($tcargoload + $tbagload).' '.$units['weight'] }}" disabled>
                    </div>
                  </div>
                @endif
                <div class="col-md">
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
            <div class="col-lg">
              @widget('Weather', ['icao' => $flight->dpt_airport_id, 'raw_only' => true])
              @if($DBasic)
                @widget('DBasic::Notams', ['icao' => $flight->dpt_airport_id])
              @endif
            </div>
            <div class="col-lg">
              @widget('Weather', ['icao' => $flight->arr_airport_id, 'raw_only' => true])
              @if($DBasic)
                @widget('DBasic::Notams', ['icao' => $flight->arr_airport_id])
              @endif
            </div>
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
                Additional Fuel Planning
                <i class="fas fa-gas-pump float-end"></i>
              </h5>
            </div>
            <div class="card-body p-1">
              <div class="input-group input-group-sm">
                <span class="input-group-text col-md-4">Minimum Block Fuel <i class="fas fa-info-circle mx-2 text-info" title="Holds already on board fuel from previous flight or defines the minimum block fuel"></i></span>
                <input class="form-control form-control-sm" id="minfob" name="minfob" type="number" placeholder="0.0" min="0" max="9999" step="0.1" value="{{ round($aircraft->fuel_onboard->local() / 1000, 1) }}"/>
                <input type='hidden' name="minfob_units" value="wgt">
              </div>
              <div class="input-group input-group-sm">
                <span class="input-group-text col-md-4">Minimum Arrival Fuel <i class="fas fa-info-circle mx-2 text-info" title="Forces minimum fuel over destination (FOD)"></i></span>
                <input class="form-control form-control-sm" id="minfod" name="minfod" type="number" placeholder="0.0" min="0" max="9999" step="0.1"/>
                <input type='hidden' name="minfod_units" value="wgt">
              </div>
              <hr class="my-1 px-1">
              <div class="input-group input-group-sm">
                <span class="input-group-text col-md-4">MEL Fuel <i class="fas fa-info-circle mx-2 text-info" title="When weight is selected it should be metric tonnes or 1000's of pounds"></i></span>
                <input class="form-control form-control-sm" id="melfuel" name="melfuel" type="number" placeholder="0.0" min="0" max="999" step="0.1"/>
                <select name="melfuel_units" class="form-control form-control-sm col-md-4">
                  <option value="wgt" selected>Weight</option>
                  <option value="min">Minutes</option>
                </select>
              </div>
              <div class="input-group input-group-sm">
                <span class="input-group-text col-md-4">ATC Fuel <i class="fas fa-info-circle mx-2 text-info" title="When weight is selected it should be metric tonnes or 1000's of pounds"></i></span>
                <input class="form-control form-control-sm" id="atcfuel" name="atcfuel" type="number" placeholder="0.0" min="0" max="999" step="0.1"/>
                <select name="atcfuel_units" class="form-control form-control-sm col-md-4">
                  <option value="wgt" selected>Weight</option>
                  <option value="min">Minutes</option>
                </select>
              </div>
              <div class="input-group input-group-sm">
                <span class="input-group-text col-md-4">WXX Fuel <i class="fas fa-info-circle mx-2 text-info" title="When weight is selected it should be metric tonnes or 1000's of pounds"></i></span>
                <input class="form-control form-control-sm" id="wxxfuel" name="wxxfuel" type="number" placeholder="0.0" min="0" max="999" step="0.1"/>
                <select name="wxxfuel_units" class="form-control form-control-sm col-md-4">
                  <option value="wgt" selected>Weight</option>
                  <option value="min">Minutes</option>
                </select>
              </div>
              <div class="input-group input-group-sm">
                <span class="input-group-text col-md-4">OPN Fuel <i class="fas fa-info-circle mx-2 text-info" title="When weight is selected it should be metric tonnes or 1000's of pounds"></i></span>
                <input class="form-control form-control-sm" id="addedfuel" name="addedfuel" type="number" placeholder="0.0" min="0" max="999" step="0.1"/>
                <select name="addedfuel_units" class="form-control form-control-sm col-md-4">
                  <option value="wgt" selected>Weight</option>
                  <option value="min">Minutes</option>
                </select>
                <input type="hidden" name="addedfuel_label" value="opn">
              </div>
              <hr class="my-1 px-1">
              <div class="input-group input-group-sm">
                <span class="input-group-text col-md-4">Fuel Tankering <i class="fas fa-info-circle mx-2 text-info" title="Metric tonnes or 1000's of pounds"></i></span>
                <input class="form-control form-control-sm" id="tankering" name="tankering" type="number" placeholder="0.0" min="0" max="60" step="0.1"/>
                @if(Theme::getSetting('simbrief_tankering'))
                  <span class="input-group-text input-group-text-append col-md-4">{!! DT_CheckTankering($flight, $aircraft) !!}</span>
                @endif
                <input type='hidden' name="tankering_units" value="wgt">
              </div>
            </div>
          </div>
        @endif
        {{-- Prepare rest of the Form fields for SimBrief --}}
          {{-- If Disposable Basic Module is installed and activated, Specs will overwrite below two form fields according to your defined specifications and pilot selections --}}
          {{-- Below value fields are just defaults and should remain in the form --}}
          <input type="hidden" id="acdata" name="acdata" value="{{'{'.$acdata.',"extrarmk":"'.$sb_rvr.$sb_callsign.$sb_ivaova.$sb_rmk.'"}'}}" readonly>
          @if($tpaxfig)
            <input type="hidden" name="pax" value="{{ $tpaxfig }}">
          @else
            <input type="hidden" name="pax" value="0">
          @endif
          @if($tcargoload)
            <input type='hidden' id='cargo' name='cargo' value="{{ number_format(($tcargoload / 1000),1) }}">
          @else
            <input type="hidden" name="cargo" value="0">
          @endif
          @if(isset($tpayload) && $tpayload > 0)
            <input type="hidden" name="manualrmk" value="Load Distribution {{ $loaddist }}">
          @endif
          <input type="hidden" name="airline" value="{{ optional($flight->airline)->code }}">
          <input type="hidden" name="fltnum" value="{{ $flight->flight_number }}">
          @if(setting('simbrief.name_private', false))
            <input type="hidden" name="cpt" value="{{ $user->name_private }}">
          @endif
          <input type="hidden" id="steh" name="steh" maxlength="2">
          <input type="hidden" id="stem" name="stem" maxlength="2">
          <input type="hidden" id="date" name="date" maxlength="9">
          @if(filled($aircraft->selcal))
            <input type="hidden" id="selcal" name="selcal" value="{{ $aircraft->selcal ?? 'BN-FK' }}">
          @endif
          <input type="hidden" id="omit_sids" name="omit_sids" value="0">
          <input type="hidden" id="omit_stars" name="omit_stars" value="0">
          <input type="hidden" id="find_sidstar" name="find_sidstar" value="R">
          <input type="hidden" id="static_id" name="static_id" value="{{ $static_id }}">
        {{-- For more info about form fields and their details check SimBrief / API Support --}}
        <div class="card bg-transparent mb-2 p-0 text-right border-0">
          <input type="button" class="btn btn-sm btn-primary" value="Generate SimBrief OFP" onclick="simbriefsubmit('{{ $flight->id }}', '{{ $aircraft->id }}', '{{ url(route('frontend.simbrief.briefing', [''])) }}');">
        </div>
      </div>
    </div>
  </form>
  @if(Theme::getSetting('simbrief_rfinder') && !$Check_SSL)
    @include('flights.simbrief_form_routefinder')
  @endif
@endsection
@include('flights.simbrief_scripts')

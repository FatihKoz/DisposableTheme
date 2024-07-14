<div class="card mb-2">
  <div class="card-header p-1">
    <h5 class="m-1">
      Planning Options
      <i class="fas fa-tasks float-end"></i>
    </h5>
  </div>
  <div class="card-body p-1 form-group">
    <div class="input-group input-group-sm">
      <span class="input-group-text col-md-5">ATC Callsign</span>
      <select id="callsign" name="callsign" class="form-select">
        @if(setting('simbrief.callsign', false))
          <option value="{{ $user->ident }}" selected>{{ $user->ident }}</option>
        @else
          @if(filled($flight->callsign))
            <option value="{{ $flight->atc }}">{{ $flight->atc }}</option>
          @endif
          @if(filled($user->callsign))
            <option value="{{ optional($flight->airline)->icao.$user->callsign }}">{{ optional($flight->airline)->icao.$user->callsign }}</option>
          @endif
          <option value="{{ optional($flight->airline)->icao.$flight->flight_number }}">{{ optional($flight->airline)->icao.$flight->flight_number }}</option>
          @if(filled($user->callsign))
            <option value="{{ $user->atc }}">{{ $user->atc }}</option>
          @endif
          <option value="{{ $user->ident }}">{{ $user->ident }}</option>
        @endif
      </select>
    </div>
    <div class="input-group input-group-sm">
      <span class="input-group-text col-md-5">Cruise Fuel Policy</span>
      <select id="cruise" name="cruise" class="form-select" onchange="DisableCI()">
        <option value="LRC">LRC (Long Range Cruise)</option>
        <option value="CI" selected>CI (Cost Index)</option>
      </select>
    </div>
    <div class="input-group input-group-sm">
      <span class="input-group-text col-md-5">Cost Index (CI)</span>
      <input type="text" id="civalue" name="civalue" class="form-control" maxlength="4" value="AUTO">
    </div>
    <div class="input-group input-group-sm">
      <span class="input-group-text col-md-5">Contingency Fuel</span>
      <select name="contpct" class="form-select">
        <option value="0">None</option>
        <option value="auto">AUTO</option>
        <option value="easa">EASA</option>
        <option value="0.03/5">3% or 05 MIN</option>
        <option value="0.03/10">3% or 10 MIN</option>
        <option value="0.03/15">3% or 15 MIN</option>
        <option value="0.05/5" selected>5% or 05 MIN</option>
        <option value="0.05/10">5% or 10 MIN</option>
        <option value="0.05/15">5% or 15 MIN</option>
        <option value="0.03">3%</option>
        <option value="0.05">5%</option>
        <option value="0.1">10%</option>
        <option value="0.15">15%</option>
        <option value="3">03 MIN</option>
        <option value="5">05 MIN</option>
        <option value="10">10 MIN</option>
        <option value="15">15 MIN</option>
      </select>
    </div>
    <div class="input-group input-group-sm">
      <span class="input-group-text col-md-5">Reserve Fuel</span>
      <select name="resvrule" class="form-select">
        <option value="auto">AUTO</option>
        <option value="0">0 MIN</option>
        <option value="15">15 MIN</option>
        <option value="30" selected>30 MIN</option>
        <option value="45">45 MIN</option>
        <option value="60">60 MIN</option>
        <option value="75">75 MIN</option>
        <option value="90">90 MIN</option>
      </select>
    </div>
    <div class="input-group input-group-sm">
      <span class="input-group-text col-md-5">SID/STAR Type</span>
      <select id="sidstar" class="form-select" onchange="SidStarSelection()">
        <option value="C">Conventional</option>
        <option value="R" selected>RNAV</option>
        <option value="NIL">Disabled</option>
      </select>
    </div>
    <div class="input-group input-group-sm">
      <span class="input-group-text col-md-5">Automatic Step Climbs</span>
      <select id="stepclimbs" name="stepclimbs" class="form-select" onchange="DisableFL()">
        <option value="0" selected>Disabled</option>
        <option value="1">Enabled</option>
      </select>
    </div>
    <div class="input-group input-group-sm">
      <span class="input-group-text col-md-5">ETOPS Planning</span>
      <select name="etops" class="form-select">
        <option value="0" selected>Disabled</option>
        <option value="1">Enabled</option>
      </select>
    </div>
    <div class="input-group input-group-sm">
      <span class="input-group-text col-md-5">Alternate Airports</span>
      <select name="altn_count" class="form-select">
        <option value="1">1</option>
        <option value="2" selected>2</option>
        <option value="3">3</option>
        <option value="4">4</option>
      </select>
    </div>
  </div>
</div>
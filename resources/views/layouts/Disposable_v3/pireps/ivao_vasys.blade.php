@if(Auth::id() === optional($pirep)->user_id)
  {{-- IVAO VA System Modal Button --}}
  <span type="button" class="badge bg-primary text-black" data-bs-toggle="modal" data-bs-target="#vasysModal{{$pirep->id}}">
    IVAO Va System
  </span>

  {{-- IVAO VA System Modal Body --}}
  <div class="modal fade" id="vasysModal{{$pirep->id}}" tabindex="-1" aria-labelledby="vasysModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header p-1">
          <h5 class="modal-title m-0 p-0" id="vasysModalLabel">IVAO VA System Report</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        @php $vasys = DT_PrepareIVAO_Report($pirep); @endphp
        @if(filled($vasys))
          <form id="pirep_form" name="FrontPage_Form1" target="_blank" action="https://www.ivao.aero/vasystem/admin/va_pirep.asp" method="POST">
            @csrf
            {{-- Hidden Fields --}}
              <input type="hidden" name="Id" value="{{ $vasys['Id'] }}"/>
              <input type="hidden" name="Pilot_VA" value="{{ $vasys['Id'] }}"/>
              <input type="hidden" name="VA_ICAO" value="{{ $vasys['VA_ICAO'] }}"/>
              <input type="hidden" name="PersonId" value="{{ $vasys['PersonId'] }}"/>
              <input type="hidden" name="Pilot_Id" value="{{ $vasys['PersonId'] }}"/>
              <input type="hidden" name="Type" value="{{ $vasys['Type'] }}"/>
              <input type="hidden" name="TasCruise" value="{{ $vasys['TasCruise'] }}"/>
            {{-- Visible Fields some for possible corrections --}}
            <div class="modal-body p-1 text-start">
              <div class="row mb-1">
                <div class="col">
                  <label class="form-label mb-1 ps-1">Connection Callsign</label>
                  <div class="input-group input-group-sm">
                    <span class="input-group-text">{{ $vasys['VA_ICAO'] }}</span>
                    <input type="text" class="form-control form-control-sm" name="Callsign" value="{{ $vasys['Callsign'] }}"/>
                  </div>
                </div>
                <div class="col">
                  <label class="form-label mb-1 ps-1">Flight Number</label>
                  <input type="text" class="form-control form-control-sm" name="Flight_Number" value="{{ $vasys['Flight_Number'] }}" readonly/>
                </div>
                <div class="col">
                  <label class="form-label mb-1 ps-1">Aircraft Type</label>
                  <input type="text" class="form-control form-control-sm" name="Aircraft" value="{{ $vasys['Aircraft'] }}" readonly/>
                </div>
              </div>
              <div class="row mb-1">
                <div class="col">
                  <label class="form-label mb-1 ps-1">Departure</label>
                  <input type="text" class="form-control form-control-sm" name="DepAirport" value="{{ $vasys['DepAirport'] }}" readonly/>
                </div>
                <div class="col">
                  <label class="form-label mb-1 ps-1">Destination</label>
                  <input type="text" class="form-control form-control-sm" name="DestAirport" value="{{ $vasys['DestAirport'] }}" readonly/>
                </div>
                <div class="col">
                  <label class="form-label mb-1 ps-1">Landed</label>
                  <input type="text" class="form-control form-control-sm" name="LandAirport" value="{{ $vasys['LandAirport'] }}" readonly/>
                </div>
                <div class="col">
                  <label class="form-label mb-1 ps-1">Alternate</label>
                  <input type="text" class="form-control form-control-sm" name="AltAirport" value="{{ $vasys['AltAirport'] }}" @if($vasys['SimBrief'] === true) readonly @endif/>
                </div>
              </div>
              <hr class="m-2">
              <div class="row mb-1">
                <div class="col">
                  <label class="form-label mb-1 ps-1">Fuel Used</label>
                  <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="Fuel_Qty" value="{{ $vasys['Fuel_Qty'] }}" readonly/>
                    <input type="text" class="form-control form-control-sm" name="Fuel_Type" value="{{ $vasys['Fuel_Type'] }}" readonly/>
                  </div>
                </div>
                <div class="col">
                  <label class="form-label mb-1 ps-1">Distance</label>
                  <div class="input-group input-group-sm">
                    <input type="text" class="form-control form-control-sm" name="Distance" value="{{ $vasys['Distance'] }}" readonly/>
                    <span class="input-group-text">Nmi</span>
                  </div>
                </div>
                <div class="col">
                  <label class="form-label mb-1 ps-1">Altitude</label>
                  <input type="text" class="form-control form-control-sm" name="Altitude" value="{{ $vasys['Altitude'] }}"/>
                </div>
              </div>
              <div class="row mb-1">
                <div class="col">
                  <label class="form-label mb-1 ps-1">Take Off Date</label>
                  <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="DateDay" value="{{ $vasys['DateDay'] }}" maxlength="2" readonly/>
                    <input type="text" class="form-control form-control-sm" name="DateMonth" value="{{ $vasys['DateMonth'] }}" maxlength="2" readonly/>
                    <input type="text" class="form-control form-control-sm" name="DateYear" value="{{ $vasys['DateYear'] }}" maxlength="4" readonly/>
                  </div>
                </div>
                <div class="col">
                  <label class="form-label mb-1 ps-1">Take Off Time</label>
                  <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="DepTime" value="{{ $vasys['DepTime'] }}" maxlength="2" @if($vasys['TakeOff'] === true) readonly @endif/>
                    <input type="text" class="form-control form-control-sm" name="ActDepTime" value="{{ $vasys['ActDepTime'] }}" maxlength="2" @if($vasys['TakeOff'] === true) readonly @endif/>
                  </div>
                </div>
                <div class="col">
                  <label class="form-label mb-1 ps-1">Landing Time</label>
                  <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="Land_Hour" value="{{ $vasys['Land_Hour'] }}" maxlength="2" @if($vasys['Landing'] === true) readonly @endif/>
                    <input type="text" class="form-control form-control-sm" name="Land_Minute" value="{{ $vasys['Land_Minute'] }}" maxlength="2" @if($vasys['Landing'] === true) readonly @endif/>
                  </div>
                </div>
              </div>
              <hr class="m-2">
              <div class="row mb-1">
                <div class="col">
                  <label class="form-label mb-1 ps-1">IFPS Route</label>
                  <input type="text" class="form-control form-control-sm" name="Route" value="{{ $vasys['Route'] }}"/>
                </div>
              </div>
            </div>
            <div class="modal-footer p-1">
              <a href="https://www.ivao.aero/Login.aspx" target="_blank" class="btn btn-primary btn-sm text-black m-0 p-0 mx-1 px-1">IVAO Login</a>
              <button type="submit" class="btn btn-success btn-sm text-black m-0 p-0 mx-1 px-1">Send Report</button>
              <button type="button" class="btn btn-warning btn-sm text-black m-0 p-0 mx-1 px-1" data-bs-dismiss="modal">Close</button>
            </div>
          </form>
        @else
          <div class="modal-body p-2 text-start">
            <span class="fw-bold">You are not an IVAO Member, check your profile and fill in your IVAO ID</span>
          </div>
          <div class="modal-footer p-1">
            <button type="button" class="btn btn-warning btn-sm m-0 p-0 mx-1 px-1" data-bs-dismiss="modal">Close</button>
          </div>
        @endif
      </div>
    </div>
  </div>
@endif
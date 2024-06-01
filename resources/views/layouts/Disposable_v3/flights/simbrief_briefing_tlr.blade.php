<div class="row row-cols-xl-2">
  <div class="col col-xl-8">
    <div class="row row-cols-2">
      {{-- TakeOff Data --}}
      <div class="col">
        <div class="card mb-2">
          <div class="card-header p-1"><h5 class="m-1">{{ $simbrief->xml->tlr->takeoff->conditions->airport_icao }} TakeOff</h5></div>
          <div class="card-body p-0 table-responsive">
            <table class="table table-sm table-striped table-borderless text-start text-nowrap align-middle mb-0">
              <tr>
                <td class="col-4">Runway</td>
                <td>{{ $simbrief->xml->tlr->takeoff->conditions->planned_runway }}</td>
              </tr>
              <tr>
                <td>Runway Surface</td>
                <td>{{ strtoupper($simbrief->xml->tlr->takeoff->conditions->surface_condition) }}</td>
              </tr>
              <tr>
                <td>Planned TOW</td>
                <td>{{ $simbrief->xml->tlr->takeoff->conditions->planned_weight }}</td>
              </tr>
              <tr>
                <td>Wind Direction</td>
                <td>{{ $simbrief->xml->tlr->takeoff->conditions->wind_direction }}</td>
              </tr>
              <tr>
                <td>Wind Speed</td>
                <td>{{ $simbrief->xml->tlr->takeoff->conditions->wind_speed }}</td>
              </tr>
              <tr>
                <td>Temperature</td>
                <td>{{ $simbrief->xml->tlr->takeoff->conditions->temperature }}</td>
              </tr>
              <tr>
                <td>Pressure</td>
                <td>{{ $simbrief->xml->tlr->takeoff->conditions->altimeter }}</td>
              </tr>
            </table>
          </div>
          <div class="card-footer p-1 small">
            {{-- TakeOff Runways --}}
            <div class="accordion accordion-flush" id="toRwys">
              @foreach($simbrief->xml->tlr->takeoff->runway as $rwy)
                <div class="accordion-item">
                  <h5 class="accordion-header" id="flush-heading-{{ $rwy->identifier }}">
                    <button class="accordion-button collapsed p-1 px-2" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{ $rwy->identifier }}" aria-expanded="false" aria-controls="flush-collapse-{{ $rwy->identifier }}">
                      Runway {{ $rwy->identifier }}
                    </button>
                  </h5>
                  <div id="flush-collapse-{{ $rwy->identifier }}" class="accordion-collapse collapse @if(trim($rwy->identifier) == trim($simbrief->xml->tlr->takeoff->conditions->planned_runway)) show @endif" aria-labelledby="flush-heading-{{ $rwy->identifier }}" data-bs-parent="#toRwys">
                    <div class="accordion-body p-0">
                      <table class="table table-sm table-striped table-borderless text-start text-nowrap align-middle mb-0">
                        <tr>
                          <td class="col-4">TORA</td>
                          <td>{{ DT_toMeter($rwy->length_tora) }}</td>
                        </tr>
                        <tr>
                          <td>TODA</td>
                          <td>{{ DT_toMeter($rwy->length_toda) }}</td>
                        </tr>
                        <tr>
                          <td>ASDA</td>
                          <td>{{ DT_toMeter($rwy->length_asda) }}</td>
                        </tr>
                        <tr>
                          <td>LDA</td>
                          <td>{{ DT_toMeter($rwy->length_lda) }}</td>
                        </tr>
                        <tr>
                          <td>HW.COMP</td>
                          <td>{{ $rwy->headwind_component }}</td>
                        </tr>
                        <tr>
                          <td>CW.COMP</td>
                          <td>{{ $rwy->crosswind_component }}</td>
                        </tr>
                        <tr>
                          <td>ELEV</td>
                          <td>{{ $rwy->elevation }}</td>
                        </tr>
                        <tr>
                          <td>SLOPE</td>
                          <td>{{ $rwy->gradient.' %' }}</td>
                        </tr>
                        <tr>
                          <td>ANTI ICE</td>
                          <td>{{ $rwy->anti_ice_setting }}</td>
                        </tr>
                        <tr>
                          <td>PACK / BLEED</td>
                          <td>{{ $rwy->bleed_setting }}</td>
                        </tr>
                        <tr>
                          <td>FLAPS</td>
                          <td>{{ $rwy->flap_setting }}</td>
                        </tr>
                        <tr>
                          <td>THR. SETTING</td>
                          <td>{{ $rwy->thrust_setting }} @if($rwy->thrust_setting == 'FLEX') {{ $rwy->flex_temperature }} @endif</td>
                        </tr>
                        @if($rwy->thrust_setting != 'FLEX')
                          <tr>
                            <td>ASSM. TEMP</td>
                            <td>{{ $rwy->flex_temperature }}</td>
                          </tr>
                        @endif
                        <tr>
                          <td>V1</td>
                          <td>{{ $rwy->speeds_v1 }}</td>
                        </tr>
                        <tr>
                          <td>VR</td>
                          <td>{{ $rwy->speeds_vr }}</td>
                        </tr>
                        <tr>
                          <td>V2</td>
                          <td>{{ $rwy->speeds_v2 }}</td>
                        </tr>
                        <tr>
                          <td>MARGIN</td>
                          <td>{{ DT_toMeter($rwy->distance_margin) }}</td>
                        </tr>
                        <tr>
                          <td>LIMIT WGT</td>
                          <td>{{ $rwy->max_weight }}</td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
          <div class="card-footer p-1 small fw-bold text-end">Distances are in @if($units['distance'] == 'km') meter @else feet @endif</div>
        </div>
      </div>
      {{-- Landing Data --}}
      <div class="col">
        <div class="card mb-2">
          <div class="card-header p-1"><h5 class="m-1">{{ $simbrief->xml->tlr->landing->conditions->airport_icao }} Landing</h5></div>
          <div class="card-body p-0 table-responsive">
            <table class="table table-sm table-striped table-borderless text-start text-nowrap align-middle mb-0">
              <tr>
                <td class="col-4">Runway</td>
                <td>{{ $simbrief->xml->tlr->landing->conditions->planned_runway }}</td>
              </tr>
              <tr>
                <td>Runway Surface</td>
                <td>{{ strtoupper($simbrief->xml->tlr->landing->conditions->surface_condition) }}</td>
              </tr>
              <tr>
                <td>Planned LW</td>
                <td>{{ $simbrief->xml->tlr->landing->conditions->planned_weight }}</td>
              </tr>
              <tr>
                <td>Wind Direction</td>
                <td>{{ $simbrief->xml->tlr->landing->conditions->wind_direction }}</td>
              </tr>
              <tr>
                <td>Wind Speed</td>
                <td>{{ $simbrief->xml->tlr->landing->conditions->wind_speed }}</td>
              </tr>
              <tr>
                <td>Temperature</td>
                <td>{{ $simbrief->xml->tlr->landing->conditions->temperature }}</td>
              </tr>
              <tr>
                <td>Pressure</td>
                <td>{{ $simbrief->xml->tlr->landing->conditions->altimeter }}</td>
              </tr>
            </table>
          </div>
          <div class="card-footer p-1 small">
            {{-- Landing Runways --}}
            <div class="accordion accordion-flush" id="lndRwys">
              @foreach($simbrief->xml->tlr->landing->runway as $rwy)
                <div class="accordion-item">
                  <h5 class="accordion-header" id="lnd-flush-heading-{{ $rwy->identifier }}">
                    <button class="accordion-button collapsed p-1 px-2" type="button" data-bs-toggle="collapse" data-bs-target="#lnd-flush-collapse-{{ $rwy->identifier }}" aria-expanded="false" aria-controls="lnd-flush-collapse-{{ $rwy->identifier }}">
                      Runway {{ $rwy->identifier }}
                    </button>
                  </h5>
                  <div id="lnd-flush-collapse-{{ $rwy->identifier }}" class="accordion-collapse collapse @if(trim($rwy->identifier) == trim($simbrief->xml->tlr->landing->conditions->planned_runway)) show @endif" aria-labelledby="lnd-flush-heading-{{ $rwy->identifier }}" data-bs-parent="#lndRwys">
                    <div class="accordion-body p-0">
                      <table class="table table-sm table-striped table-borderless text-start text-nowrap align-middle mb-0">
                        <tr>
                          <td class="col-4">LDA</td>
                          <td>{{ DT_toMeter($rwy->length_lda) }}</td>
                        </tr>
                        <tr>
                          <td>ELEV</td>
                          <td>{{ $rwy->elevation }}</td>
                        </tr>
                        <tr>
                          <td>SLOPE</td>
                          <td>{{ $rwy->gradient.' %' }}</td>
                        </tr>
                        <tr>
                          <td>ILS/LOC FREQ</td>
                          <td>{{ $rwy->ils_frequency }}</td>
                        </tr>
                        <tr>
                          <td>COURSE</td>
                          <td>{{ $rwy->magnetic_course }}</td>
                        </tr>
                        <tr>
                          <td>HW.COMP</td>
                          <td>{{ $rwy->headwind_component }}</td>
                        </tr>
                        <tr>
                          <td>CW.COMP</td>
                          <td>{{ $rwy->crosswind_component }}</td>
                        </tr>
                        <tr>
                          <td>PERF WGT</td>
                          <td>
                            @if(trim($simbrief->xml->tlr->landing->conditions->surface_condition) == 'dry')
                              {{ $simbrief->xml->tlr->landing->distance_dry->weight }}
                            @else
                              {{ $simbrief->xml->tlr->landing->distance_wet->weight }}
                            @endif
                          </td>
                        </tr>
                        <tr>
                          <td>FLAPS</td>
                          <td>
                            @if(trim($simbrief->xml->tlr->landing->conditions->surface_condition) == 'dry')
                              {{ $simbrief->xml->tlr->landing->distance_dry->flap_setting }}
                            @else
                              {{ $simbrief->xml->tlr->landing->distance_wet->flap_setting }}
                            @endif
                          </td>
                        </tr>
                        <tr>
                          <td>BRAKE</td>
                          <td>
                            @if(trim($simbrief->xml->tlr->landing->conditions->surface_condition) == 'dry')
                              {{ $simbrief->xml->tlr->landing->distance_dry->brake_setting }}
                            @else
                              {{ $simbrief->xml->tlr->landing->distance_wet->brake_setting }}
                            @endif
                          </td>
                        </tr>
                        <tr>
                          <td>VREF</td>
                          <td>
                            @if(trim($simbrief->xml->tlr->landing->conditions->surface_condition) == 'dry')
                              {{ $simbrief->xml->tlr->landing->distance_dry->speeds_vref }}
                            @else
                              {{ $simbrief->xml->tlr->landing->distance_wet->speeds_vref }}
                            @endif
                          </td>
                        </tr>
                        <tr>
                          <td>REQ DISTANCE</td>
                          <td>
                            @if(trim($simbrief->xml->tlr->landing->conditions->surface_condition) == 'dry')
                              {{ DT_toMeter($simbrief->xml->tlr->landing->distance_dry->factored_distance) }}
                            @else
                              {{ DT_toMeter($simbrief->xml->tlr->landing->distance_wet->factored_distance) }}
                            @endif
                          </td>
                        </tr>
                        <tr>
                          <td>LIMIT WGT</td>
                          <td>
                            @if(trim($simbrief->xml->tlr->landing->conditions->surface_condition) == 'dry')
                              {{ $rwy->max_weight_dry }}
                            @else
                              {{ $rwy->max_weight_wet }}
                            @endif
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
          <div class="card-footer p-1 small fw-bold text-end">Distances are in @if($units['distance'] == 'km') meter @else feet @endif</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col col-xl-4">
    <div class="card mb-2">
      <div class="card-header p-1">
        <h5 class="m-1">
          Performance Analysis Report
          <i class="fas fa-plane float-end"></i>
        </h5>
      </div>
      <div class="card-body p-1 overflow-auto" style="max-height: 45rem; font-family: Verdana, sans-serif; font-size: 0.75rem;">
        {!!  str_replace("\n", "<br>", $simbrief->xml->text->tlr_section) !!}
      </div>
      <div class="card-footer p-1 small fw-bold">&nbsp;</div>
    </div>
  </div>
</div>
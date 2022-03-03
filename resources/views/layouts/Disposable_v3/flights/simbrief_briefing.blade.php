@extends('app')
@section('title', 'Briefing')
@include('theme_helpers')
@php
  $units = isset($units) ? $units : DT_GetUnits();
  $DBasic = isset($DBasic) ? $DBasic : DT_CheckModule('DisposableBasic');
  $now = Carbon::now();
@endphp
@section('content')
  <div class="row row-cols-xl-2">
    <div class="col-xl-11">
      <div class="accordion accordion-flush" id="sb-accordion">
        <div class="accordion-item">
          <h5 class="accordion-header" id="headingOne">
            <button class="accordion-button p-1 px-2" type="button" data-bs-toggle="collapse" data-bs-target="#summary" aria-expanded="true" aria-controls="summary">
              Summary
            </button>
          </h5>
          <div id="summary" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#sb-accordion">
            <div class="accordion-body p-1 pt-2">
              @include('flights.simbrief_briefing_info')
            </div>
          </div>
        </div>
        @if($simbrief->created_at->diffInDays($now) <= 2 || $simbrief->updated_at->diffInDays($now) <= 2)
          <div class="accordion-item">
            <h5 class="accordion-header" id="headingTwo">
              <button class="accordion-button p-1 px-2 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#charts" aria-expanded="false" aria-controls="charts">
                Route & SigWX Charts
              </button>
            </h5>
            <div id="charts" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#sb-accordion">
              <div class="accordion-body p-1 pt-2">
                @include('flights.simbrief_briefing_sigwx')
              </div>
            </div>
          </div>
        @endif
        <div class="accordion-item">
          <h5 class="accordion-header" id="headingThree">
            <button class="accordion-button p-1 px-2 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#livewx" aria-expanded="false" aria-controls="livewx">
              Live Weather
            </button>
          </h5>
          <div id="livewx" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#sb-accordion">
            <div class="accordion-body p-1 pt-2">
              @include('flights.simbrief_briefing_wx')
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-1">
      <div class="d-flex align-items-start">
        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
          @if($simbrief->flight_id && $user->id == $simbrief->user_id && $acars_plugin)
            <a class="btn btn-sm btn-success my-1" href="@if(isset($bid)) {{'vmsacars:bid/'.$bid->id}} @else {{'vmsacars:flight/'.$simbrief->flight_id}} @endif">vmsAcars</a>
          @endif
          <a class="btn btn-sm btn-primary my-1" data-bs-toggle="modal" data-bs-target="#ofp-view" href="#">View</a>
          @if(filled($simbrief->xml->params->static_id) && $user->id == $simbrief->user_id && $simbrief->flight_id)
            <a class="btn btn-sm btn-warning my-1" data-bs-toggle="modal" data-bs-target="#ofp-edit" href="#">Edit</a>
          @endif
          @if($user->id == $simbrief->user_id && $simbrief->flight_id)
            <a class="btn btn-sm btn-danger my-1" href="{{ url(route('frontend.simbrief.generate_new', [$simbrief->id])) }}">Generate New</a>
          @endif
          @if(!$simbrief->pirep_id && $user->id == $simbrief->user_id && Theme::getSetting('pireps_manual'))
            <a class="btn btn-sm btn-info my-1" href="{{ url(route('frontend.simbrief.prefile', [$simbrief->id])) }}">Manual PIREP</a>
          @endif
        </div>
      </div>
      <canvas id="qr-code" class="card bg-white my-3 mx-1 p-1"></canvas>
    </div>
  </div>

  {{-- SimBrief View OFP Modal --}}
  <div class="modal fade" id="ofp-view" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="ofp-viewLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" style="max-width: 475px; max-height: 90vh;">
      <div class="modal-content">
        <div class="modal-header border-0 p-1">
          <h6 class="m-1">
            Operational Flight Plan | SimBrief
          </h6>
          <button type="button" class="btn-close mx-1" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body border-0 p-1">
          @if($simbrief->xml->params->units == 'lbs' && $units['weight'] === 'kg' || $simbrief->xml->params->units == 'kgs' && $units['weight'] === 'lbs' )
            <p class="small text-uppercase p-1 mb-1"><b>*** ALL WEIGHTS IN {{ $simbrief->xml->params->units }} ***</b></p>
          @endif
          {!! $simbrief->xml->text->plan_html !!}
        </div>
        <div class="modal-footer border-0 text-end p-1">
          <button type="button" class="btn btn-danger btn-sm m-0 mx-1 p-0 px-1" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  {{-- SimBrief Edit OFP Modal --}}
  @if(!empty($simbrief->xml->params->static_id))
    <div class="modal fade" id="ofp-edit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="ofp-editLabel" aria-hidden="true">
      <div class="modal-dialog" style="max-width: 1020px;">
        <div class="modal-content">
          <div class="modal-header border-0 p-1">
            <h6 class="m-1">
              Edit OFP | SimBrief
            </h6>
            <button type="button" class="btn-close mx-1" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body border-0 p-0">
            <iframe src="https://www.simbrief.com/system/dispatch.php?editflight=last&static_id={{ $simbrief->xml->params->static_id }}" style="width: 100%; height: 82vh; display:block;" frameBorder="0" title="SimBrief"></iframe>
          </div>
          <div class="modal-footer border-0 text-end p-1">
            <a
              class="btn btn-success btn-sm m-0 mx-1 p-0 px-1"
              href="{{ route('frontend.simbrief.update_ofp') }}?ofp_id={{ $simbrief->id }}&flight_id={{ $simbrief->flight_id }}&aircraft_id={{ $simbrief->aircraft_id }}&sb_userid={{ $simbrief->xml->params->user_id }}&sb_static_id={{ $simbrief->xml->params->static_id }}">
              Download New OFP & Close
            </a>
            <button type="button" class="btn btn-danger btn-sm m-0 mx-1 p-0 px-1" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  @endif
@endsection

@section('scripts')
  @parent
  <script>
    $(document).ready(function () {
      $("#download_fms").click(e => {
        e.preventDefault();
        const select = document.getElementById("download_fms_select");
        const link = select.options[select.selectedIndex].value;
        console.log('Downloading FMS: ', link);
        window.open(link, '_blank');
      });
    });
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
  <script>
    var qr;
    (function() {
      qr = new QRious({
        element: document.getElementById('qr-code'),
        size: 100,
        value: "{{ url('/').'/simbrief/'.$simbrief->id }}"
      });
    })();
  </script>
@endsection
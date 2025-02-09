@extends('app')
@section('title', trans_choice('common.pirep', 1).' '.$pirep->ident)
@include('theme_helpers')
@php
  $units = isset($units) ? $units : DT_GetUnits();
  $DBasic = isset($DBasic) ? $DBasic : check_module('DisposableBasic');
  $DSpecial = isset($DSpecial) ? $DSpecial : check_module('DisposableSpecial');
  $AuthCheck = Auth::check();
  $pirep->loadMissing('acars');
  $violations = $pirep->acars_logs->filter(function ($item) { return str_contains($item['log'], 'iolat'); });
  // $logs = $pirep->acars_logs->filter(function ($item) { return !str_contains($item['log'], 'iolat'); });
@endphp
@section('content')
  <div class="row">
    {{-- LEFT --}}
    <div class="col-lg-8">
      @include('pireps.show_card')

      <div class="card mb-2">
        <div class="card-header p-1">
          {{-- Inner Navigation --}}
          <h5 class="m-1">
            <i class="fas fa-cogs float-end"></i>
            <ul class="nav nav-tabs m-0 p-0 border-0" id="PirepTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active border-0 m-0 mx-1 p-0 px-1" id="map-tab" data-bs-toggle="tab" data-bs-target="#map" type="button" role="tab" aria-controls="map" aria-selected="true">
                  Route Map
                </button>
              </li>
              @if($AuthCheck && $pirep->acars && $pirep->acars->count() > 0)
                <li class="nav-item" role="presentation">
                  <button class="nav-link border-0 m-0 mx-1 p-0 px-1" id="chart-tab" data-bs-toggle="tab" data-bs-target="#chart" type="button" role="tab" aria-controls="chart" aria-selected="true">
                    Altitude & Speed Chart
                  </button>
                </li>
              @endif
              @if($AuthCheck && $pirep->fields && $pirep->fields->count() > 0)
                <li class="nav-item" role="presentation">
                  <button class="nav-link border-0 m-0 mx-1 p-0 px-1" id="fields-tab" data-bs-toggle="tab" data-bs-target="#fields" type="button" role="tab" aria-controls="details" aria-selected="false">
                    {{ trans_choice('common.pirep', 1).' '.trans_choice('common.field', 2) }}
                  </button>
                </li>
              @endif
              @if($AuthCheck && $pirep->acars_logs && $pirep->acars_logs->count() > 0)
                <li class="nav-item" role="presentation">
                  <button class="nav-link border-0 m-0 mx-1 p-0 px-1" id="log-tab" data-bs-toggle="tab" data-bs-target="#log" type="button" role="tab" aria-controls="log" aria-selected="false">
                    @lang('pireps.flightlog')
                  </button>
                </li>
              @endif
              @if($AuthCheck && $pirep->comments && $pirep->comments->count() > 0)
                <li class="nav-item" role="presentation">
                  <button class="nav-link border-0 m-0 mx-1 p-0 px-1" id="comments-tab" data-bs-toggle="tab" data-bs-target="#comments" type="button" role="tab" aria-controls="comments" aria-selected="false">
                    Comments
                  </button>
                </li>
              @endif
              @if($AuthCheck && $violations->count() > 0)
                <li class="nav-item" role="presentation">
                  <button class="nav-link border-0 m-0 mx-1 p-0 px-1" id="violations-tab" data-bs-toggle="tab" data-bs-target="#violations" type="button" role="tab" aria-controls="violations" aria-selected="false">
                    Rule Violations
                  </button>
                </li>
              @endif
            </ul>
          </h5>
        </div>
        <div class="card-body table-responsive p-0">
          {{-- Navigation Contents --}}
          <div class="tab-content" id="PirepTabContent">
            @php $tab_height = '62vh'; @endphp
            <div class="tab-pane fade show active" id="map" role="tabpanel" aria-labelledby="map-tab">
              @include('pireps.map', ['map_height' => $tab_height])
            </div>
            @if($AuthCheck && $pirep->acars && $pirep->acars->count() > 0)
              <div class="tab-pane fade show" id="chart" role="tabpanel" aria-labelledby="chart-tab">
                @include('pireps.chart')
              </div>
            @endif
            @if($AuthCheck && $pirep->fields && $pirep->fields->count() > 0 && $pirep->fields->count() <= 150)
              <div class="tab-pane fade overflow-auto" style="max-height: {{ $tab_height }};" id="fields" role="tabpanel" aria-labelledby="fields-tab">
                <table class="table table-sm table-borderless table-striped text-nowrap align-middle mb-0">
                  @foreach($pirep->fields as $field)
                    <tr>
                      <td class="col-md-3">{{ $field->name }}</td>
                      <td>{!! DT_PirepField($field, $units) !!}</td>
                    </tr>
                  @endforeach
                </table>
              </div>
            @endif
            @if($AuthCheck && $pirep->acars_logs && $pirep->acars_logs->count() > 0 && $pirep->acars_logs->count() <= 250)
              <div class="tab-pane fade overflow-auto" style="max-height: {{ $tab_height }};" id="log" role="tabpanel" aria-labelledby="logs-tab">
                <table class="table table-sm table-borderless table-striped text-nowrap align-middle mb-0">
                  @foreach($pirep->acars_logs->sortBy('created_at') as $log)
                    <tr>
                      <td class="col-md-3">{{ $log->created_at->format('d.M.Y H:i') }}</td>
                      <td>{{ $log->log }}</td>
                    </tr>
                  @endforeach
                </table>
              </div>
            @endif
            @if($AuthCheck && $pirep->comments->count() > 0)
              <div class="tab-pane fade" id="comments" role="tabpanel" aria-labelledby="comments-tab">
                <table class="table table-sm table-borderless table-striped text-nowrap align-middle mb-0">
                  @foreach($pirep->comments as $comment)
                    <tr>
                      <td class="col-3">{{ $comment->created_at->format('d.M.Y H:i') }}</td>
                      <td>{{ $comment->comment }}</td>
                    </tr>
                  @endforeach
                </table>
              </div>
            @endif
            @if($AuthCheck && $violations->count() > 0)
            <div class="tab-pane fade overflow-auto" style="max-height: {{ $tab_height }};" id="violations" role="tabpanel" aria-labelledby="violations-tab">
              <table class="table table-sm table-borderless table-striped text-nowrap align-middle mb-0">
                @foreach($violations->sortBy('created_at') as $log)
                  <tr>
                    <td class="col-md-3">{{ $log->created_at->format('d.M.Y H:i') }}</td>
                    <td>{{ $log->log }}</td>
                  </tr>
                @endforeach
              </table>
            </div>
          @endif
          </div>
        </div>
        <div class="card-footer p-1">
          @if(filled($pirep->route))
            <i class="fas fa-route m-1" title="Planned Route"></i>
            {{ $pirep->dpt_airport_id.' '.$pirep->route }}
          @endif
        </div>
      </div>
    </div>
    {{-- RIGHT --}}
    <div class="col-lg-4">
      @include('pireps.show_details')
      @include('pireps.show_finance')
    </div>
  </div>

  {{-- SimBrief OFP Modal --}}
  @if(!empty($pirep->simbrief))
    <div class="modal fade" id="OFP_Modal" tabindex="-1" aria-labelledby="OFP_ModalLabel" aria-hidden="true">
      <div class="modal-dialog" style="max-width: 470px;">
        <div class="modal-content">
          <div class="modal-header p-0">
            <h6 class="modal-title m-1" id="OFP_ModalLabel">
              Operational Flight Plan
            </h6>
            <button type="button" class="btn-close me-1" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-1 ps-2 overflow-auto" style="max-height: 80vh;">
            @if($pirep->simbrief->xml->params->units == 'lbs' && $units['weight'] === 'kg' || $pirep->simbrief->xml->params->units == 'kgs' && $units['weight'] === 'lbs' )
              <p class="small text-uppercase p-1 mb-1">
                <b>*** ALL WEIGHTS IN {{ $pirep->simbrief->xml->params->units }} ***</b>
              </p>
            @endif
            {!! $pirep->simbrief->xml->text->plan_html !!}
          </div>
          <div class="modal-footer p-1">
            <button type="button" class="btn btn-sm m-0 mx-1 p-0 px-1 btn-warning text-black" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  @endif
@endsection
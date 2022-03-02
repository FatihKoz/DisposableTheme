@extends('app')
@section('title', $airport->full_name)
@include('theme_helpers')
@php
  $DBasic = isset($DBasic) ? $DBasic : DT_CheckModule('DisposableBasic');
  $units = isset($units) ? $units : DT_GetUnits();
@endphp
@section('content')
  <div class="row">
    {{-- LEFT --}}
    <div class="col-lg-4">
      <div class="card mb-2">
        <div class="card-header p-1">
          <h5 class="m-1">
            {{ $airport->name }}
            <i class="fas fa-info float-end"></i>
          </h5>
        </div>
        <div class="card-body p-0 table-responsive">
          <table class="table table-sm table-borderless table-striped align-middle text-end mb-0">
            <tr>
              <th class="text-start">@lang('disposable.icao_iata_code')</th>
              <td>{{ $airport->icao.' / '.$airport->iata }}</td>
            </tr>
            <tr>
              <th class="text-start">@lang('user.location') / @lang('common.country')</th>
              <td>{{ $airport->location.' / '.$airport->country }}</td>
            </tr>
            @if(filled($airport->timezone))
              <tr>
                <th class="text-start">@lang('common.timezone')</th>
                <td>{{ $airport->timezone }}</td>
              </tr>
            @endif
            @if($airport->ground_handling_cost > 0)
              <tr>
                <th class="text-start">@lang('disposable.gh_cost')</th>
                <td>{{ number_format($airport->ground_handling_cost).' '.$units['currency'].'/'.trans_choice('common.flight',1) }}</td>
              </tr>
            @endif
            @if($airport->fuel_mogas_cost > 0)
              <tr>
                <th class="text-start">@lang('disposable.mogas_cost')</th>
                <td>{{ DT_FuelCost($airport->fuel_mogas_cost, $units['fuel'], $units['currency']) }}</td>
              </tr>
            @endif
            @if($airport->fuel_100ll_cost > 0)
              <tr>
                <th class="text-start">@lang('disposable.100ll_cost')</th>
                <td>{{ DT_FuelCost($airport->fuel_100ll_cost, $units['fuel'], $units['currency']) }}</td>
              </tr>
            @endif
            @if($airport->fuel_jeta_cost > 0)
              <tr>
                <th class="text-start">@lang('disposable.jeta1_cost')</th>
                <td>{{ DT_FuelCost($airport->fuel_jeta_cost, $units['fuel'], $units['currency']) }}</td>
              </tr>
            @endif
            @if($DBasic)
              <tr>
                <th class="text-start">@lang('disposable.avg_taxi_times')</th>
                <td>Out: {{ DB_AvgTaxiTime($airport->id, 'out', 10) }} min | In: {{ DB_AvgTaxiTime($airport->id, 'in', 5) }} min</td>
              </tr>
            @endif
          </table>
        </div>
        @if($DBasic)
          <div class="card-footer p-0">
            @widget('DBasic::SunriseSunset', ['location' => $airport->id, 'card' => false])
          </div>
        @endif
      </div>
      @if($DBasic && Theme::getSetting('gen_map_flight'))
        @widget('DBasic::Map', ['source' => $airport->id])
      @endif
      {{-- Show Pills For Map/WX/Downloads--}}
      <ul class="nav nav-pills nav-justified mb-2" id="pills-tab" role="tablist">
        <li class="nav-item mx-1" role="presentation">
          <a class="nav-link active pt-1 pb-1" id="pills-map-tab" data-toggle="pill" href="#pills-map" role="tab" aria-controls="pills-map" aria-selected="true">
            @lang('disposable.map')
          </a>
        </li>
        @if($DBasic)
          <li class="nav-item mx-1" role="presentation">
            <a class="nav-link pt-1 pb-1" id="pills-wxmap-tab" data-toggle="pill" href="#pills-wxmap" role="tab" aria-controls="pills-wxmap" aria-selected="true">
              WX @lang('disposable.map')
            </a>
          </li>
        @endif
        <li class="nav-item mx-1" role="presentation">
          <a class="nav-link pt-1 pb-1" id="pills-weather-tab" data-toggle="pill" href="#pills-weather" role="tab" aria-controls="pills-weather" aria-selected="false">
            @lang('disposable.weather')
          </a>
        </li>
        @if(count($airport->files) > 0 && Auth::check())
          <li class="nav-item mx-1" role="presentation">
            <a class="nav-link pt-1 pb-1" id="pills-files-tab" data-toggle="pill" href="#pills-files" role="tab" aria-controls="pills-files" aria-selected="false">
              {{ trans_choice('common.download', 2) }}
            </a>
          </li>
        @endif
      </ul>
    </div>
    {{-- RIGHT --}}
    <div class="col-lg-8">
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-map" role="tabpanel" aria-labelledby="pills-map-tab">
          <div class="card mb-2">
            <div class="card-header p-1">
              <h5 class="m-1">
                {{ $airport->full_name }}
                <i class="fas fa-map float-end"></i>
              </h5>
            </div>
            <div class="card-body p-0">
              @widget('AirspaceMap', ['width' => '100%', 'height' => '500px', 'lat' => $airport->lat, 'lon' => $airport->lon])
            </div>
            <div class="card-footer p-0 px-1 small text-end">
              <b>{{ $airport->location.' / '.strtoupper($airport->country) }}</b>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="pills-weather" role="tabpanel" aria-labelledby="pills-weather-tab">
          @widget('Weather', ['icao' => $airport->icao])
        </div>
        @if($DBasic)
          <div class="tab-pane fade" id="pills-wxmap" role="tabpanel" aria-labelledby="pills-wxmap-tab">
            <div class="card mb-2">
              <div class="card-header p-1">
                <h5 class="m-1">
                  {{ $airport->full_name }}
                  <i class="fas fa-cloud-sun-rain float-end"></i>
                </h5>
              </div>
              <div class="card-body p-0">
                @include('DBasic::pages.livewx_map' , ['lat' => $airport->lat, 'lon' => $airport->lon, 'zoom' => 8, 'height' => '500px', 'marker' => true])
              </div>
              <div class="card-footer p-0 px-1 small text-end">
                <b>{{ $airport->location.' / '.strtoupper($airport->country) }}</b>
              </div>
            </div>
          </div>
        @endif
        @if(count($airport->files) > 0 && Auth::check())
          <div class="tab-pane fade" id="pills-files" role="tabpanel" aria-labelledby="pills-files-tab">
            <div class="card mb-2">
              <div class="card-header p-1">
                <h5 class="m-1">
                  {{ trans_choice('common.download', 2) }}
                  <i class="fas fa-download float-end"></i>
                </h5>
              </div>
              <div class="card-body p-0">
                @include('downloads.table', ['files' => $airport->files])
              </div>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>

  <div class="row row-cols-lg-2">
    <div class="col">
      @if($inbound_flights)
        <div class="card mb-2">
          <div class="card-header p-1">
            <h5 class="m-1">
              @lang('flights.inbound')
              <i class="fas fa-plane-arrival float-end"></i>
            </h5>
          </div>
          <div class="card-body p-0 overflow-auto">
            @include('flights.table_compact', ['flights' => $inbound_flights, 'type' => 'arr'])
          </div>
          <div class="card-footer p-0 px-1 text-end small">
            <b>@lang('disposable.total') {{ count($inbound_flights) }}</b>
          </div>
        </div>
      @endif
    </div>
    <div class="col">
      @if($outbound_flights)
        <div class="card mb-2">
          <div class="card-header p-1">
            <h5 class="m-1">
              @lang('flights.outbound')
              <i class="fas fa-plane-departure float-end"></i>
            </h5>
          </div>
          <div class="card-body p-0 overflow-auto">
            @include('flights.table_compact', ['flights' => $outbound_flights, 'type' => 'dep'])
          </div>
          <div class="card-footer p-0 px-1 text-end small">
            <b>@lang('disposable.total') {{ count($outbound_flights) }}</b>
          </div>
        </div>
      @endif
    </div>
  </div>

  @if($DBasic)
    <div class="row row-cols-lg-3">
      <div class="col">
        @widget('DBasic::AirportAssets', ['type' => 'aircraft', 'location' => $airport->id])
      </div>
      <div class="col">
        @widget('DBasic::AirportAssets', ['type' => 'pilots', 'location' => $airport->id])
      </div>
      <div class="col">
        @widget('DBasic::AirportAssets', ['type' => 'pireps', 'location' => $airport->id])
      </div>
    </div>
  @endif
@endsection
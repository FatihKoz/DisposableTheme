@if ($config['raw_only'] != true && $metar)
  <div class="card mb-2">
    <div class="card-header p-1">
      <h5 class="m-1">
        @lang('dashboard.weatherat', ['ICAO' => strtoupper($config['icao'])])
        <i class="fas fa-cloud-sun float-end"></i>
      </h5>
    </div>
    <div class="card-body p-0 table-responsive">
      <table class="table table-sm table-striped table-borderless text-start align-middle mb-0">
      <tr>
        <th>Conditions</th>
        <td>@if($metar['category'] === 'VFR') VMC @elseif($metar['category'] === 'IFR') IMC @else {{ $metar['category'] }} @endif</td>
      </tr>
      <tr>
        <th>Wind</th>
        <td>
          @if($metar['wind_speed'] <= '3')
            Calm
          @else
            {{ $metar['wind_speed'].' kts' }} @lang('common.from') {{ $metar['wind_direction_label'].' '.$metar['wind_direction'] }}&deg;
          @endif
          @if($metar['wind_gust_speed'])
            @lang('widgets.weather.guststo') {{ $metar['wind_gust_speed'] }}
          @endif
        </td>
      </tr>
      @if($metar['visibility'])
        <tr>
          <th>Visibility</th>
          <td>{{ $metar['visibility_report'] }}</td>
        </tr>
      @endif
      @if($metar['runways_visual_range'])
        <tr>
          <th>Runway Visual Range</th>
          <td>
            @foreach($metar['runways_visual_range'] as $rvr)
              <b>{{ 'RWY'.$rvr['runway'].'; ' }}</b> {{ $rvr['report'] }}<br>
            @endforeach
          </td>
        </tr>
      @endif
      @if($metar['present_weather_report'] && $metar['present_weather_report'] <> 'Dry')
        <tr>
          <th>Phenomena</th>
          <td>{{ $metar['present_weather_report'] }}</td>
        </tr>
      @endif
      @if($metar['clouds'] || $metar['cavok'])
        <tr>
          <th>Clouds</th>
          <td>
            @if($unit_alt === 'ft')
              {{ $metar['clouds_report_ft'] }}
            @else
              {{ $metar['clouds_report'] }}
            @endif
            @if($metar['cavok'] == 1)
              Ceiling and Visibility OK
            @endif
          </td>
        </tr>
      @endif
      @if($metar['temperature'])
        <tr>
          <th>Temperature</th>
          <td>
            @if($metar['temperature'][$unit_temp])
              {{ $metar['temperature'][$unit_temp] }}
            @else
              0
            @endif &deg;{{ strtoupper($unit_temp) }}
            @if($metar['dew_point'])
              , @lang('widgets.weather.dewpoint')
              @if($metar['dew_point'][$unit_temp])
                {{ $metar['dew_point'][$unit_temp] }}
              @else
                0
              @endif &deg;{{strtoupper($unit_temp)}}
            @endif
            @if($metar['humidity'])
              , @lang('widgets.weather.humidity') {{ $metar['humidity'] }}&#37;
            @endif
          </td>
        </tr>
      @endif
      @if($metar['barometer'])
        <tr>
          <th>Pressure</th>
          <td>{{ number_format($metar['barometer']['hPa']) }} hPa / {{ number_format($metar['barometer']['inHg'], 2) }} inHg</td>
        </tr>
      @endif
      @if($metar['recent_weather_report'])
        <tr>
          <th>Recent Phenomena</th>
          <td>{{ $metar['recent_weather_report'] }}</td>
        </tr>
      @endif
      @if($metar['runways_report'])
        <tr>
          <th>Runway Condition</th>
          <td>
            @foreach($metar['runways_report'] as $runway)
              @if($runway['runway'] == '88')
                <b>All Runways;</b>
              @else
                <b>{{ 'RWY'.$runway['runway'].'; ' }}</b>
              @endif
              {{ $runway['report'] }}
              <br>
            @endforeach
          </td>
        </tr>
      @endif
      @if($metar['remarks'])
        <tr>
          <th>Remarks</th>
          <td>{{ $metar['remarks'] }}</td>
        </tr>
      @endif
      <tr>
        <th>Observation Time</th>
        <td>{{ $metar['observed_time'] }} ({{ $metar['observed_age'] }})</td>
      </tr>
      </table>
    </div>
  </div>
@endif

<div class="card mb-2">
  {{--}}
  <div class="card-header p-1">
    <h5 class="m-1">
      METAR & TAF | {{ strtoupper($config['icao']) }}
      <i class="fas fa-cloud-sun float-end"></i>
    </h5>
  </div>
  {{--}}
  <div class="card-body p-0 table-responsive">
    <table class="table table-sm table-striped table-borderless mb-0">
      <tr>
        <th>METAR</th>
        <td>
          @if($metar)
            {{ $metar['raw'] }}
          @else
            @lang('widgets.weather.nometar')
          @endif
        </td>
      </tr>
        <tr>
          <th>TAF</th>
          <td>
            @if($taf)
              {{ $taf['raw'] }}
            @else
              @lang('widgets.weather.nometar')
            @endif
          </td>
        </tr>
    </table>
  </div>
</div>

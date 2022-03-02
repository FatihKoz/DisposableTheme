{{-- ROW WITH ICONS --}}
<div class="row mb-0">

  <div class="col-lg">
    <div class="card bg-transparent shadow-none text-dark border-0 mb-2">
      <div class="card-body bg-transparent p-0">
        <i class="fas fa-paper-plane fa-2x pt-1 float-end text-primary"></i>
        <h6 class="card-title m-0 p-0 text-center">{{ $user->flights }}</h6>
        <h6 class="card-title m-0 p-0 text-center small">{{ trans_choice('common.flight', $user->flights) }}</h6>
      </div>
    </div>
  </div>

  <div class="col-lg">
    <div class="card bg-transparent shadow-none text-dark border-0 mb-2">
      <div class="card-body bg-transparent p-0">
        <i class="fas fa-clock fa-2x pt-1 float-end text-danger"></i>
        <h6 class="card-title m-0 p-0 text-center">@minutestotime($user->flight_time)</h6>
        <h6 class="card-title m-0 p-0 text-center small">@lang('pireps.flighttime')</h6>
      </div>
    </div>
  </div>

  @if($DBasic)
    <div class="col-lg">
      <div class="card bg-transparent shadow-none text-dark border-0 mb-2">
        <div class="card-body bg-transparent p-0">
          <i class="fas fa-plane-arrival fa-2x pt-1 float-end text-success"></i>
          <h6 class="card-title m-0 p-0 text-center">@widget('DBasic::PersonalStats', ['user' => $user->id, 'type' => 'avglanding'])</h6>
          <h6 class="card-title m-0 p-0 text-center small">@lang('disposable.avg_lrate')</h6>
        </div>
      </div>
    </div>

    <div class="col-lg">
      <div class="card bg-transparent shadow-none text-dark border-0 mb-2">
        <div class="card-body bg-transparent p-0">
          <i class="fas fa-pen-alt fa-2x pt-1 float-end text-secondary"></i>
          <h6 class="card-title m-0 p-0 text-center">@widget('DBasic::PersonalStats', ['user' => $user->id, 'type' => 'avgscore'])</h6>
          <h6 class="card-title m-0 p-0 text-center small">@lang('disposable.avg_score')</h6>
        </div>
      </div>
    </div>

    <div class="col-lg">
      <div class="card bg-transparent shadow-none text-dark border-0 mb-2">
        <div class="card-body bg-transparent p-0">
          <i class="fas fa-stopwatch fa-2x pt-1 float-end text-warning"></i>
          <h6 class="card-title m-0 p-0 text-center">@widget('DBasic::PersonalStats', ['user' => $user->id, 'type' => 'avgtime'])</h6>
          <h6 class="card-title m-0 p-0 text-center small">@lang('disposable.avg_ftime')</h6>
        </div>
      </div>
    </div>

    <div class="col-lg">
      <div class="card bg-transparent shadow-none text-dark border-0 mb-2">
        <div class="card-body bg-transparent p-0">
          <i class="fas fa-gas-pump fa-2x pt-1 float-end text-info"></i>
          <h6 class="card-title m-0 p-0 text-center">@widget('DBasic::PersonalStats', ['user' => $user->id, 'type' => 'avgfuel'])</h6>
          <h6 class="card-title m-0 p-0 text-center small">@lang('disposable.avg_fused')</h6>
        </div>
      </div>
    </div>
  @endif

  <div class="col-lg">
    <div class="card bg-transparent shadow-none text-dark border-0 mb-2">
      <div class="card-body bg-transparent p-0">
        <i class="fas fa-map-marker fa-2x pt-1 float-end text-success"></i>
        <h6 class="card-title m-0 p-0 text-center">{{ $current_airport ?? '--' }}</h6>
        <h6 class="card-title m-0 p-0 text-center small">@lang('airports.current')</h6>
      </div>
    </div>
  </div>

  <div class="col-lg">
    <div class="card bg-transparent shadow-none text-dark border-0 mb-2">
      <div class="card-body bg-transparent p-0">
        <i class="fas fa-coins fa-2x pt-1 float-end text-primary"></i>
        <h6 class="card-title m-0 p-0 text-center">{{ optional($user->journal)->balance }}</h6>
        <h6 class="card-title m-0 p-0 text-center small">@lang('dashboard.yourbalance')</h6>
      </div>
    </div>
  </div>

</div>
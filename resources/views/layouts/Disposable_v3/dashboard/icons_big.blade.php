{{-- ROW WITH ICONS --}}
<div class="row mb-1">

  <div class="col">
    <div class="card bg-transparent shadow-none text-dark border-0 mb-2">
      <div class="card-body bg-transparent p-0">
        <i class="bi bi-send fa-3x float-end text-primary"></i>
        <h5 class="card-title m-0 p-0 text-center">{{ $user->flights }}</h5>
        <h6 class="card-title m-0 p-0 text-center">{{ trans_choice('common.flight', $user->flights) }}</h6>
      </div>
    </div>
  </div>

  <div class="col">
    <div class="card bg-transparent shadow-none text-dark border-0 mb-2">
      <div class="card-body bg-transparent p-0">
        <i class="bi bi-clock fa-3x float-end text-danger"></i>
        <h5 class="card-title m-0 p-0 text-center">@minutestotime($user->flight_time)</h5>
        <h6 class="card-title m-0 p-0 text-center">@lang('pireps.flighttime')</h6>
      </div>
    </div>
  </div>

  @if($DBasic)
    <div class="col">
      <div class="card bg-transparent shadow-none text-dark border-0 mb-2">
        <div class="card-body bg-transparent p-0">
          <i class="bi bi-airplane fa-3x float-end text-success"></i>
          <h5 class="card-title m-0 p-0 text-center">@widget('DBasic::PersonalStats', ['user' => $user->id, 'type' => 'avglanding'])</h5>
          <h6 class="card-title m-0 p-0 text-center">@lang('disposable.avg_lrate')</h6>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card bg-transparent shadow-none text-dark border-0 mb-2">
        <div class="card-body bg-transparent p-0">
          <i class="bi bi-pencil fa-3x float-end text-secondary"></i>
          <h5 class="card-title m-0 p-0 text-center">@widget('DBasic::PersonalStats', ['user' => $user->id, 'type' => 'avgscore'])</h5>
          <h6 class="card-title m-0 p-0 text-center">@lang('disposable.avg_score')</h6>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card bg-transparent shadow-none text-dark border-0 mb-2">
        <div class="card-body bg-transparent p-0">
          <i class="bi bi-stopwatch fa-3x float-end text-warning"></i>
          <h5 class="card-title m-0 p-0 text-center">@widget('DBasic::PersonalStats', ['user' => $user->id, 'type' => 'avgtime'])</h5>
          <h6 class="card-title m-0 p-0 text-center">@lang('disposable.avg_ftime')</h6>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card bg-transparent shadow-none text-dark border-0 mb-2">
        <div class="card-body bg-transparent p-0">
          <i class="bi bi-fuel-pump fa-3x float-end text-info"></i>
          <h5 class="card-title m-0 p-0 text-center">@widget('DBasic::PersonalStats', ['user' => $user->id, 'type' => 'avgfuel'])</h5>
          <h6 class="card-title m-0 p-0 text-center">@lang('disposable.avg_fused')</h6>
        </div>
      </div>
    </div>
  @endif

  <div class="col">
    <div class="card bg-transparent shadow-none text-dark border-0 mb-2">
      <div class="card-body bg-transparent p-0">
        <i class="bi bi-pin-map fa-3x float-end text-success"></i>
        <h5 class="card-title m-0 p-0 text-center">{{ $current_airport ?? '--' }}</h5>
        <h6 class="card-title m-0 p-0 text-center">@lang('airports.current')</h6>
      </div>
    </div>
  </div>

  <div class="col">
    <div class="card bg-transparent shadow-none text-dark border-0 mb-2">
      <div class="card-body bg-transparent p-0">
        <i class="bi bi-cash-stack fa-3x float-end text-primary"></i>
        <h5 class="card-title m-0 p-0 text-center">{{ optional($user->journal)->balance }}</h5>
        <h6 class="card-title m-0 p-0 text-center">@lang('dashboard.yourbalance')</h6>
      </div>
    </div>
  </div>

</div>
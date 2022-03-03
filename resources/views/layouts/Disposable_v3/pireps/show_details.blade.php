<div class="card mb-2">
  <div class="card-header p-1">
    <h5 class="m-1">
      {{ trans_choice('common.pirep', 1) }}
      <i class="fas fa-info float-end"></i>
    </h5>
  </div>
  <div class="card-body p-0 table-responsive">
    <table class="table table-sm table-borderless table-striped align-middle mb-0">
      <tr>
        <th>
          <i class="fas fa-user mx-1"></i>
          <a href="{{ route('frontend.profile.show', [$pirep->user_id]) }}">
            {{ optional($pirep->user)->name_private }}
          </a>
        </th>
        <th class="text-end">
          {{ $pirep->user->rank->name ?? '--' }}
          <i class="fas fa-tag mx-1"></i>
        </th>
      </tr>
      <tr>
        <td>
          <i class="fas fa-plane mx-1"></i>
          @if($DBasic) <a href="{{ route('DBasic.aircraft', [optional($pirep->aircraft)->registration ?? '']) }}"> @endif
            {{ optional($pirep->aircraft)->ident }}
            @if($pirep->aircraft && $pirep->airline_id != $pirep->aircraft->airline->id)
            | {{ $pirep->aircraft->airline->name ?? '' }}
            @endif
          @if($DBasic) </a> @endif
        </td>
        <td class="text-end">
          @if($DBasic) <a href="{{ route('DBasic.airline', [optional($pirep->airline)->icao ?? '']) }}"> @endif
            {{ optional($pirep->airline)->name }}
          @if($DBasic) </a> @endif
          <i class="fas fa-home mx-1"></i>
        </td>
      </tr>
    </table>
    <hr class="my-1">
    <table class="table table-sm table-borderless table-striped align-middle mb-0">
      @if($AuthCheck)
        <tr>
          <td class="text-start col-4" title="Source">
            <i class="fas fa-laptop mx-1"></i>
            {{ PirepSource::label($pirep->source) }}
          </td>
          <td class="text-center col-4" title="Score">
            @if(filled($pirep->score))
              <i class="fas fa-pen-alt mx-1"></i>
              {{ $pirep->score }}
            @endif
          </td>
          <td class="text-end col-4" title="Landing Rate">
            @if($pirep->landing_rate != 0)
              {{ number_format($pirep->landing_rate).' ft/min' }}
            @endif
            <i class="fas fa-plane-arrival mx-1"></i>
          </td>
        </tr>
      @endif
      @if($pirep->block_fuel || $pirep->fuel_used)
        <tr>
          <td class="text-start col-4" title="Block Fuel">
            <i class="fas fa-plane-departure mx-1"></i>
            {{ DT_ConvertWeight($pirep->block_fuel, $units['fuel']) }}
          </td>
          <td class="text-center col-4" title="Fuel Used">
            <i class="fas fa-gas-pump mx-1"></i>
            {{ DT_ConvertWeight($pirep->fuel_used, $units['fuel']) }}
          </td>
          <td class="text-end col-4" title="Remaining Fuel">
            @if($pirep->block_fuel && $pirep->fuel_used)
              {{ number_format($pirep->block_fuel->local() - $pirep->fuel_used->local()).' '.$units['fuel'] }}
              {{-- DT_ConvertWeight($pirep->block_fuel->local() - $pirep->fuel_used->local(), $units['fuel']) --}}
            @endif
            <i class="fas fa-plane-arrival mx-1"></i>
          </td>
        </tr>
      @endif
      @if($pirep->source != 0 && filled($pirep->created_at) && filled($pirep->submitted_at))
        <tr>
          <td class="text-start col-4" title="Flight Start">
            <i class="fas fa-file mx-1"></i>
            {{ $pirep->created_at->format('H:i') }}
          </td>
          <td class="text-center col-4" title="Duty Time">
            <i class="fas fa-stopwatch mx-1"></i>
            {{ DT_ConvertMinutes($pirep->created_at->diffInMinutes($pirep->submitted_at), '%2dh %2dm') }}
          </td>
          <td class="text-end col-4" title="Flight End">
            {{ $pirep->submitted_at->format('H:i') }}
            <i class="fas fa-file-upload mx-1"></i>
          </td>
        </tr>
      @endif
      @if(filled($pirep->notes) && $AuthCheck)
        <tr>
          <td colspan="3">
            <i class="fas fa-file-alt mx-1"></i>
            {{ $pirep->notes }}
          </td>
        </tr>
      @endif
    </table>
  </div>
  <div class="card-footer p-1 text-center">
    <div class="float-start">
      {!! DT_PirepStatus($pirep) !!}
      {!! DT_PirepState($pirep) !!}
      @if($DBasic && Theme::getSetting('gen_stable_approach'))
        @widget('DBasic::StableApproach', ['pirep' => $pirep])
      @endif
      @if($pirep->comments->count() > 0)
        <span class="badge bg-info text-black">Check Comments</span>
      @endif
    </div>
    @if(!empty($pirep->simbrief))
      <div class="float-end">
        <a class="badge bg-secondary text-black" href="{{ route('frontend.simbrief.briefing', $pirep->simbrief->id) }}" target="_blank">
          SimBrief Briefing
        </a>
        <span type="button" class="badge bg-primary text-black" data-bs-toggle="modal" data-bs-target="#OFP_Modal">
          SimBrief OFP
        </span>
      </div>
    @endif
  </div>
  {{--}}
  <div class="card-footer p-0 table-responsive">
    <table class="table table-sm table-borderless table-striped align-middle mb-0">
      <tr>
        <td class="text-start">
          {!! DT_PirepStatus($pirep) !!}
          {!! DT_PirepState($pirep) !!}
          @widget('DBasic::StableApproach', ['pirep' => $pirep, 'type' => 'badge'])
        </td>
        @if($pirep->comments->count() > 0)
          <td class="text-center">
            <span class="badge bg-warning text-black">Check Comments</span>
          </td>
        @endif
        @if(!empty($pirep->simbrief))
          <td class="text-end">
            <span type="button" class="badge bg-primary text-black" data-bs-toggle="modal" data-bs-target="#OFP_Modal">
              SimBrief OFP
            </span>
            <a class="badge bg-secondary text-black" href="{{ route('frontend.simbrief.briefing', $pirep->simbrief->id) }}" target="_blank">
              SimBrief Briefing
            </a>
          </td>
        @endif
      </tr>
    </table>
  </div>
  {{--}}
</div>
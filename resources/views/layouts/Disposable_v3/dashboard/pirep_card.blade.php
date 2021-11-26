<div class="card mb-2">
  <div class="card-header p-1">
    <h5 class="m-1">
      @lang('disposable.lpirep')
      <i class="fas fa-file-upload float-end"></i>
    </h5>
  </div>
  <div class="card-body p-0 table-responsive">
    <table class="table table-sm table-borderless table-striped align-middle text-start mb-0">
      <tr>
        <th>@lang('flights.flightnumber')</th>
        <th>@lang('airports.departure')</th>
        <th>@lang('airports.arrival')</th>
        <th class="text-center">@lang('common.aircraft')</th>
        <th class="text-center">@lang('disposable.score')</th>
        <th class="text-center">@lang('disposable.lrate')</th>
        <th class="text-end">@lang('common.state')</th>
      </tr>
      <tr>
        <td>
          <a href="{{ route('frontend.pireps.show', [$pirep->id]) }}">{{ $pirep->ident }}</a>
        </td>
        <td>
          <a href="{{ route('frontend.airports.show', [$pirep->dpt_airport_id]) }}">{{ optional($pirep->dpt_airport)->full_name ?? $pirep->dpt_airport_id }}</a>
        </td>
        <td>
          <a href="{{ route('frontend.airports.show', [$pirep->arr_airport_id]) }}">{{ optional($pirep->arr_airport)->full_name ?? $pirep->arr_airport_id }}</a>
        </td>
        <td class="text-center">
          @if($DBasic) <a href=" {{ route('DBasic.aircraft', [optional($pirep->aircraft)->registration ?? '']) }}"> @endif
            {{ optional($pirep->aircraft)->ident }}
          @if($DBasic) </a> @endif
        </td>
        <td class="text-center">
          @if(filled($pirep->score))
            {{ $pirep->score }}
          @endif
        </td>
        <td class="text-center">
          @if(filled($pirep->landing_rate))
            {{ $pirep->landing_rate.' ft/min' }}
          @endif
        </td>
        <td class="text-end">
          {!! DT_PirepState($pirep, 'badge') !!}
        </td>
      </tr>
      @if($pirep->comments->count() > 0)
        @foreach($pirep->comments as $comment)
          <tr>
            <td colspan="7">&bull; {!! $comment->comment !!}</td>
          </tr>
        @endforeach
      @endif
    </table>
  </div>
  <div class="card-footer p-0 px-1 text-end small fw-bold">
    {{ $pirep->submitted_at->diffForHumans() }}
  </div>
</div>
@if($pireps->count())
  @php 
    $DBasic = isset($DBasic) ? $DBasic : DT_CheckModule('DisposableBasic');
  @endphp
  <div class="card mb-2">
    <div class="card-header p-1">
      <h5 class="m-1">
        @lang('dashboard.recentreports')
        <i class="fas fa-file-upload float-end"></i>
      </h5>
    </div>
    <div class="card-body p-0 table-responsive">
      <table class="table table-sm table-borderless table-striped align-middle mb-0">
        @foreach($pireps as $p)
          <tr>
            <th>
              {{ $p->ident }}
            </th>
            <td>
              <a href="{{route('frontend.airports.show', [$p->dpt_airport_id])}}">{{ $p->dpt_airport_id }}</a>
            </td>
            <td>
              <a href="{{route('frontend.airports.show', [$p->arr_airport_id])}}">{{$p->arr_airport_id}}</a>
            </td>
            <td class="text-center">
              @if($DBasic) <a href="{{ route('DBasic.aircraft', [optional($p->aircraft)->registration ?? '']) }}"> @endif
                {{ optional($p->aircraft)->ident }}
              @if($DBasic) </a> @endif
            </td>
            <td class="text-end">
              {{ $p->submitted_at->diffForHumans() }}
            </td>
          </tr>
        @endforeach
      </table>
    </div>
  </div>
@endif
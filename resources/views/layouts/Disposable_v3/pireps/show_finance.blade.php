@if($AuthCheck && (count($pirep->fares) > 0 || count($pirep->transactions) > 0))
  <div class="card mb-2">
    <div class="card-header p-1">
      <h5 class="m-1">
        <i class="fas fa-file-invoice float-end"></i>
        <ul class="nav nav-tabs m-0 p-0 border-0" id="FinanceTab" role="tablist">
          @if(count($pirep->fares) > 0)
            <li class="nav-item" role="presentation">
              <button class="nav-link border-0 m-0 mx-1 p-0 px-1" id="fares-tab" data-bs-toggle="tab" data-bs-target="#fares" type="button" role="tab" aria-controls="fares" aria-selected="false">
                Load Info
              </button>
            </li>
          @endif
          @if(count($pirep->transactions) > 0)
            <li class="nav-item" role="presentation">
              <button class="nav-link active border-0 m-0 mx-1 p-0 px-1" id="finance-tab" data-bs-toggle="tab" data-bs-target="#finance" type="button" role="tab" aria-controls="finance" aria-selected="true">
                Finance
              </button>
            </li>
          @endif
        </ul>
      </h5>
    </div>
    <div class="card-body p-0">
      <div class="tab-content" id="FinanceTabContent">
        <div class="tab-pane fade" id="fares" role="tabpanel" aria-labelledby="fares-tab">
          <table class="table table-sm table-borderless table-striped align-middle mb-0">
            <th class="col-3">
              @lang('pireps.class')
            </th>
            <th class="text-end">
              @lang('pireps.count')
            </th>
            @foreach($pirep->fares->sortBy('count', SORT_NATURAL) as $fare)
              <tr>
                <td class="col-3">{{ optional($fare->fare)->name.' ('.optional($fare->fare)->code.')' }}</td>
                <td class="text-end">
                  {{ $fare->count }}
                  @if($fare->fare->type === 1) {{ $units['weight'] }} @else pax @endif
                </td>
              </tr>
            @endforeach
          </table>
        </div>
        <div class="tab-pane fade show active" id="finance" role="tabpanel" aria-labelledby="finance-tab">
          <table class="table table-sm table-borderless table-striped text-end align-middle mb-0">
            <tr>
              <th class="text-start">
                Items
              </th>
              <th>
                Credit
              </th>
              <th>
                Debit
              </th>
            </tr>
            @foreach($pirep->transactions->where('journal_id', $pirep->airline->journal->id) as $entry)
              <tr>
                <td class="text-start">{{ $entry->memo }}</td>
                <td>@if($entry->credit){{ money($entry->credit, $units['currency']) }}@endif</td>
                <td>@if($entry->debit){{ money($entry->debit, $units['currency']) }}@endif</td>
              </tr>
            @endforeach
            <tr>
              <td>
                @php
                  $p_credit = $pirep->transactions->where('journal_id', $pirep->airline->journal->id)->sum('credit');
                  $p_debit = $pirep->transactions->where('journal_id', $pirep->airline->journal->id)->sum('debit');
                  $p_balance = $p_credit - $p_debit;
                @endphp
              </td>
              <th>{{ money($p_credit, $units['currency']) }}</th>
              <th>{{ money($p_debit, $units['currency']) }}</th>
            </tr>
          </table>
          <div class="card-footer p-1 text-end">
            <span class="float-start">
              <b>Balance</b>
            </span>
            <span style="color: @if($p_balance > 0) darkgreen @else darkred @endif;">
              <b>{{ money($p_balance, $units['currency']) }}</b>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
@endif
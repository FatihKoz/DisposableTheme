<div class="card mb-2">
  <div class="card-header p-1">
    <h5 class="m-1">
      @lang('common.newestpilots')
      <i class="fas fa-users float-end"></i>
    </h5>
  </div>
  <div class="card-body p-0 table-responsive">
    <table class="table table-sm table-borderless table-striped text-start text-nowrap align-middle mb-0">
      @foreach($users as $u)
        <tr>
          <td>
            @if(filled($u->country))
              <span class="flag-icon flag-icon-{{ $u->country }} mt-1 mx-1" title="{{ strtoupper($u->country) }}"></span>
            @endif
            <a href="{{ route('frontend.profile.show', [$u->id]) }}">{{ $u->ident.' | '.$u->name_private }}</a>
          </td>
          <td>
            <a href="{{ route('frontend.airports.show', [$u->home_airport_id ?? '']) }}">{{ optional($u->home_airport)->name ?? $u->home_airport_id }}</a>
          </td>
          <td class="text-end">{{ $u->created_at->diffForHumans() }}</td>
        </tr>
      @endforeach
    </table>
  </div>
</div>
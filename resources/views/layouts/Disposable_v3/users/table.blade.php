<table class="table table-sm table-borderless table-striped align-middle text-center text-nowrap mb-0" id="users-table">
  <thead>
    @if(Theme::getSetting('roster_userimage'))
      <th class="text-start" style="width: 50px;"></th>
    @endif
    <th class="text-start">@lang('common.name')</th>
    <th>@lang('airports.home')</th>
    @if(Theme::getSetting('roster_airline'))
      <th>@lang('common.airline')</th>
    @endif
    <th>@lang('airports.current')</th>
    <th>@lang('disposable.rank')</th>
    <th>{{ trans_choice('common.flight', 2) }}</th>
    <th>{{ trans_choice('common.hour', 2) }}</th>
    <th>@lang('disposable.awards')</th>
    @if(Theme::getSetting('roster_ivao'))
      <th>IVAO</th>
    @endif
    @if(Theme::getSetting('roster_vatsim'))
      <th>VATSIM</th>
    @endif
  </thead>
  <tbody>
    @foreach($users as $user)
      <tr @if($user->state != 1) {!! DT_UserState($user, 'row') !!} @endif>
        @if(Theme::getSetting('roster_userimage'))
          <td class="text-start">
            @if($user->avatar == null)
              <img class="rounded border border-dark img-mh50" src="{{ $user->gravatar(256) }}" alt=""/>
            @else
              <img class="rounded border border-dark img-mh50" src="{{ $user->avatar->url }}" alt=""/>
            @endif
          </td>
        @endif
        <td class="text-start">
          @if(filled($user->country) && strlen($user->country) === 2 && Theme::getSetting('roster_flags'))
            <span class="mx-1 p-0 float-end flag-icon flag-icon-{{ $user->country }}" title="{{ $country->alpha2($user->country)['name'] }}" style="font-size: 1.2rem;"></span>
          @endif
          <a href="{{ route('frontend.profile.show', [$user->id]) }}">
            @if(Theme::getSetting('roster_ident'))
              {{$user->ident}}&nbsp;
            @endif
            {{ $user->name_private }}
          </a>
        </td>
        <td>
          @if(filled($user->home_airport_id))
            @if($DBasic)
              <a href="{{ route('DBasic.hub', [$user->home_airport_id ?? ''])}}">
            @else
              <a href="{{ route('frontend.airports.show', [$user->home_airport_id ?? ''])}}">
            @endif
                {{ optional($user->home_airport)->full_name ?? $user->home_airport_id }}
              </a>
          @endif
        </td>
        @if(Theme::getSetting('roster_airline'))
          <td>
            @if($DBasic) 
              <a href="{{ route('DBasic.airline', [optional($user->airline)->icao ?? '']) }}">
            @endif
            @if($user->airline && filled($user->airline->logo))
              <img class="rounded img-mh40" src="{{ $user->airline->logo }}" title="{{ $user->airline->name }}" alt=""/>
            @else
              {{ optional($user->airline)->name }}
            @endif
            @if($DBasic)
              </a>
            @endif
          </td>
        @endif
        <td>
          @if(filled($user->curr_airport_id))
            <a href="{{ route('frontend.airports.show', [$user->curr_airport_id ?? ''])}}">
              {{ optional($user->current_airport)->full_name ?? $user->curr_airport_id }}
            </a>
          @endif
        </td>
        <td>
          @if($user->rank && filled($user->rank->image_url))
            <img class="rounded img-mh40" src="{{ $user->rank->image_url }}" title="{{ $user->rank->name }}" alt=""/>
          @else
            {{ optional($user->rank)->name }}
          @endif
        </td>
        <td>
          @if($user->flights > 0)
            {{ number_format($user->flights) }}
          @endif
        </td>
        <td>
          @if(Theme::getSetting('roster_combinetimes'))
            {{ DT_ConvertMinutes($user->flight_time + $user->transfer_time, '%2dh %02dm') }}
          @else
            {{ DT_ConvertMinutes($user->flight_time, '%2dh %02dm') }}
          @endif
        </td>
        <td>
          @if($user->awards_count > 0)
            <i class="fas fa-trophy fa-lg" style="color: darkgreen;" title="{{ $user->awards_count }}"></i>
          @endif
        </td>
        @if(Theme::getSetting('roster_ivao'))
          <td>
            @php $ivao_id = optional($user->fields->firstWhere('name', Theme::getSetting('gen_ivao_field')))->value; @endphp
            <a href='https://www.ivao.aero/member?Id={{ $ivao_id }}' target='_blank'>{{ $ivao_id }}</a>
          </td>
        @endif
        @if(Theme::getSetting('roster_vatsim'))
          <td>
            @php $vatsim_id = optional($user->fields->firstWhere('name', Theme::getSetting('gen_vatsim_field')))->value; @endphp
            <a href='https://stats.vatsim.net/search_id.php?id={{ $vatsim_id }}' target='_blank'>{{ $vatsim_id }}</a>
          </td>
        @endif
      </tr>
    @endforeach
  </tbody>
</table>
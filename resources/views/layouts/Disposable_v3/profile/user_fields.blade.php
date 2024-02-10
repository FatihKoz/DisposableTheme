<div class="row">
  <div class="col-lg-5">
    <div class="card mb-2 table-responsive">
      <table class="table table-sm table-borderless table-striped align-middle text-start mb-0">
        <tr>
          <th class="col-md-4">@lang('disposable.registered')</th>
          <td>{{ $user->created_at->diffForHumans() }}</td>
        </tr>
        <tr>
          <th>@lang('common.state')</th>
          <th>{!! DT_UserState($user) !!}</th>
        </tr>
        @foreach($userFields->where('active', 1) as $field)
          @if(!$field->private && $field->name != Theme::getSetting('gen_ivao_field') && $field->name != Theme::getSetting('gen_vatsim_field'))
            <tr>
              <th class="col-md-4">
                {{ $field->name }}
                @if(filled($field->description))
                  <i class="fas fa-info-circle mx-2 text-primary" title="{{ $field->description }}"></i>
                @endif
              </th>
              <td>{{ $field->value ?? '--'}}</td>
            </tr>
          @endif
        @endforeach
      </table>
    </div>
  </div>
</div>
@ability('admin', 'admin-access')
  <div class="row">
    @if($DSpecial)
      <div class="col-lg-5">
        @widget('DSpecial::Assignments', ['user' => $user->id, 'hide' => false])
        @ability('admin', 'admin-user')
          <div class="float-end">
            <form class="form" method="post" action="{{ route('DSpecial.assignments_manual') }}">
              @csrf
              <input type="hidden" name="curr_page" value="{{ url()->full() }}">
              <input type="hidden" name="userid" value="{{ $user->id }}">
              <input type="hidden" name="resetmonth" value="true">
              <button class="btn btn-sm bg-danger p-0 px-1 mb-2 text-black" type="submit" onclick="return confirm('Are you REALLY sure ? This will DELETE and re-assign flights of this user!')">
                Re-Assign Current Month
              </button>
            </form>
          </div>
        @endability
      </div>
      <div class="col-lg-5">
        @widget('DSpecial::TourProgress', ['user' => $user->id])
      </div>
    @endif
  </div>
@endability
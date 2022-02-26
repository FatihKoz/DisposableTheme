<div class="row">
  <div class="col-5">
    <div class="card mb-2 table-responsive">
      <table class="table table-sm table-borderless table-striped align-middle text-start mb-0">
        <tr>
          <th class="col-4">@lang('disposable.registered')</th>
          <td>{{ $user->created_at->diffForHumans() }}</td>
        </tr>
        <tr>
          <th>@lang('common.state')</th>
          <th>{!! DT_UserState($user) !!}</th>
        </tr>
        @foreach($userFields->where('active', 1) as $field)
          @if(!$field->private && $field->name != Theme::getSetting('gen_ivao_field') && $field->name != Theme::getSetting('gen_vatsim_field'))
          {{-- @if(!$field->private) --}}
            <tr>
              <th class="col-4">
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
      <div class="col-5">
        @widget('DSpecial::TourProgress', ['user' => $user->id])
      </div>
      <div class="col-5">
        @widget('DSpecial::Assignments', ['user' => $user->id, 'hide' => false])
      </div>
    @endif
  </div>
@endability
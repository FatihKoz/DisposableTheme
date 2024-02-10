@php
  $readonly = (!empty($pirep) && $pirep->read_only) ? 'readonly' : null;
@endphp
@if($aircraft)
  <div class="form-container">
    <h6 class="m-1">
      <i class="fas fa-ellipsis-h me-1"></i>
      {{ trans_choice('pireps.fare', 2) }}
    </h6>
    <div class="form-group">
      <div class="row row-cols-lg-4">
        @foreach($aircraft->subfleet->fares as $fare)
          <div class="col-lg">
            <div class="input-group input-group-sm">
              <span class="input-group-text">{{ $fare->name.' ('.$fare->code.')' }}</span>
              <input class="form-control" type="number" name="fare_{{ $fare->id }}" id="fare_{{ $fare->id }}" value="{{ $fare->count }}" min="0" {{ $readonly }}>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
@endif
@extends('app')
@section('title', 'SimBrief Flight Planning')
@include('theme_helpers')
@php
  $units = isset($units) ? $units : DT_GetUnits();    
@endphp
@section('content')
  <div class="row">
    <div class="col">
      <div class="card col-6">
        <div class="card-header p-1">
          <h5 class="m-1">
            Aircraft Selection
            <i class="fas fa-check-double float-end"></i>
          </h5>
        </div>
        <div class="card-body p-1">
          <select id="aircraftselection" class="form-control select2" onchange="checkacselection()">
            <option value="ZZZZZ">Please Select An Aircraft</option>
            @foreach($aircrafts as $ac)
              <option value="{{ $ac->id }}">
                [{{ $ac->icao }}] {{ $ac->registration }} @if($ac->registration != $ac->name)'{{ $ac->name }}'@endif
                @if(filled($ac->fuel_onboard))
                  {{ ' ('.__('disposable.fuel_ob').': '.DT_ConvertWeight($ac->fuel_onboard, $units['fuel']).')' }}
                @endif
              </option>
            @endforeach
          </select>
        </div>
        <div class="card-footer p-1 text-end">
          <a 
            id="generate_link" style="visibility: hidden" 
            href="{{ route('frontend.simbrief.generate') }}?flight_id={{ $flight->id }}"
            class="btn btn-primary btn-sm m-0 mx-1 p-0 px-1">
            Proceed To Flight Planning
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  @parent
  <script type="text/javascript">
    // Simple Aircraft Selection With Dropdown Change
    // Also keep Generate button hidden until a valid AC selection
    const $oldlink = document.getElementById("generate_link").href;

    function checkacselection() {
      if (document.getElementById("aircraftselection").value === "ZZZZZ") {
        document.getElementById('generate_link').style.visibility = 'hidden';
      } else {
        document.getElementById('generate_link').style.visibility = 'visible';
      }
      const selectedac = document.getElementById("aircraftselection").value;
      const newlink = "&aircraft_id=".concat(selectedac);

      document.getElementById("generate_link").href = $oldlink.concat(newlink);
    }
  </script>
@endsection
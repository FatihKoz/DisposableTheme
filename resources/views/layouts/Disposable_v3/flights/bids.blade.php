@extends('app')
@section('title', __('flights.mybid'))
@include('theme_helpers')
@php
  $units = isset($units) ? $units : DT_GetUnits();
  $DBasic = isset($DBasic) ? $DBasic : DT_CheckModule('DisposableBasic');
  $DSpecial = isset($DSpecial) ? $DSpecial : DT_CheckModule('DisposableSpecial');
  $tour_codes = ($DSpecial) ? DS_GetTourCodes() : [];
  $auto_extend = (setting('bids.allow_multiple_bids') === false) ? 'show' : '';
@endphp
@section('content')
  @if(!$flights->count())
    <div class="alert alert-info mb-1 p-1 px-2 fw-bold">You have no bids</div>
  @else
    <div class="row">
      <div class="col">
        @include('flights.bids_card')
      </div>
    </div>
  @endif
@endsection

@include('flights.scripts')
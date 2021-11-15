@extends('app')
@section('title', __('flights.mybid'))
@include('theme_helpers')
@section('content')
  @if(!$flights->count())
    <div class="alert alert-info mb-1 p-1 px-2 fw-bold">You have no bids</div>
  @else
    <div class="row">
      <div class="col">
        <div class="card mb-2">
          <div class="card-header p-1">
            <h5 class="m-1">
              @lang('flights.mybid')
              <i class="fas fa-file-signature float-end"></i>
            </h5>
          </div>
          <div class="card-body p-0 table-responsive">
            @include('flights.table')
          </div>
          <div class="card-footer p-0 px-1 small text-end">
            <b>{{ $flights->count() }} Bids</b>
          </div>
        </div>
      </div>
    </div>
  @endif
@endsection

@include('flights.scripts')
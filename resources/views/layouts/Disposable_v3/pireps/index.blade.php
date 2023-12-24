@extends('app')
@section('title', trans_choice('common.pirep', 2))
@include('theme_helpers')
@php
  $units = isset($units) ? $units : DT_GetUnits();
  $DBasic = isset($DBasic) ? $DBasic : DT_CheckModule('DisposableBasic');
@endphp
@section('content')
@if(!$pireps->count())
  <div class="alert alert-info mb-1 p-1 px-2 fw-bold">You have no flight reports</div>
  @if(Theme::getSetting('pireps_manual'))
    <a class="btn btn-sm btn-info m-0 mx-1 p-0 px-1 float-start" href="{{ route('frontend.pireps.create') }}">@lang('disposable.new_pirep')</a>
  @endif
@else
  <div class="row">
    <div class="col">
      <div class="card mb-2">
        <div class="card-header p-1">
          <h5 class="m-1">
            {{ trans_choice('pireps.pilotreport', 2) }}
            <i class="fas fa-file-upload float-end"></i>
          </h5>
        </div>
        <div class="card-body p-0 table-responsive">
          @include('pireps.table')
        </div>
        <div class="card-footer p-1 text-end small">
          @if(Theme::getSetting('pireps_manual'))
            <a class="btn btn-sm btn-info m-0 mx-1 p-0 px-1 float-start" href="{{ route('frontend.pireps.create') }}">@lang('disposable.new_pirep')</a>
          @endif
          @if($pireps->count() > 0)
            <b>@lang('disposable.pagination', ['first' => $pireps->firstItem(),'last' => $pireps->lastItem(),'total' =>$pireps->total()])</b>
          @endif
        </div>
      </div>
    </div>
  </div>
  {{ $pireps->withQueryString()->links('pagination.auto') }}
@endif
@endsection
@extends('app')
@section('title', __('pireps.fileflightreport'))
@include('theme_helpers')
@php
  $units = isset($units) ? $units : DT_GetUnits();
  $DBasic = isset($DBasic) ? $DBasic : check_module('DisposableBasic');
@endphp

@section('content')
  @if(Theme::getSetting('pireps_manual'))
    <div class="row">
      <div class="col">
        <div class="card mb-2">
          <div class="card-header p-1">
            <h5 class="m-1">
              @lang('pireps.newflightreport')
              <i class="fas fa-file-upload float-end"></i>
            </h5>
          </div>
          <form class="form" method="post" action="{{ route('frontend.pireps.store') }}">
            @csrf
            @include('pireps.fields')
          </form>
        </div>
      </div>
    </div>
  @else
    <div class="alert alert-danger mb-1 p-1 px-2 fw-bold">Manual Pilot/Flight Reports are disabled</div>
  @endif
@endsection

@include('pireps.scripts')
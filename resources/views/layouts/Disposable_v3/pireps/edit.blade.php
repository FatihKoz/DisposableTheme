@extends('app')
@section('title', __('pireps.editflightreport'))
@include('theme_helpers')
@php
  $units = isset($units) ? $units : DT_GetUnits();
  $DBasic = isset($DBasic) ? $DBasic : DT_CheckModule('DisposableBasic');
@endphp

@section('content')
  <div class="row">
    <div class="col">
      <div class="card mb-2">
        <div class="card-header p-1">
          <h5 class="m-1">
            @lang('pireps.editflightreport')
            <i class="fas fa-file-upload float-end"></i>
          </h5>
        </div>
        {{ Form::model($pirep, ['route' => ['frontend.pireps.update', $pirep->id], 'class' => 'form-group', 'method' => 'patch']) }}
        @include('pireps.fields')
        {{ Form::close() }}
      </div>
    </div>
  </div>
@endsection

@include('pireps.scripts')
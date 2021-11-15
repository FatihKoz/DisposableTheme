@extends('app')
@section('title', trans_choice('common.pilot', 2))
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
            {{ trans_choice('common.pilot', 2) }}
            <i class="fas fa-users float-end"></i>
          </h5>
        </div>
        <div class="card-body p-0 table-responsive">
          @include('users.table')
        </div>
        <div class="card-footer p-0 px-1 small text-end fw-bold">
          @if(setting('pilots.hide_inactive'))
            <span class="float-start">
              @lang('disposable.only_active', ['days' => setting('pilots.auto_leave_days')])
            </span>
          @endif
          @if($users->firstItem() != $users->total())
            @lang('disposable.pagination', ['first' => $users->firstItem(), 'last' => $users->lastItem(), 'total' => $users->total()])
          @endif
        </div>
      </div>
      {{ $users->links('pagination.auto') }}
    </div>
  </div>
@endsection
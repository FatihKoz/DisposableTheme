@extends('app')
@section('title', __('errors.404.title'))

@section('content')
  <div class="row">
    <div class="col-8 mx-auto content-center">
      <div class="card mb-2">
        <div class="card-header p-1">
          <h5 class="m-1">
            @lang('errors.404.title')
            <i class="fas fa-bomb float-end"></i>
          </h5>
        </div>
        <div class="card-body p-1">
          {!! str_replace(':link', config('app.url'), __('errors.404.message')) !!}
        </div>
        @if($exception->getMessage())
          <div class="card-footer p-1 small text-danger">
            {{ $exception->getMessage() }}
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection

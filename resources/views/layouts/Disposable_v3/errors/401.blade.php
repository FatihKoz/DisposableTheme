@extends('app')
@section('title', __('errors.401.title'))

@section('content')
  <div class="row">
    <div class="col-lg-8 mx-auto content-center">
      <div class="card mb-2">
        <div class="card-header p-1">
          <h5 class="m-1">
            @lang('errors.401.title')
            <i class="fas fa-bomb float-end"></i>
          </h5>
        </div>
        <div class="card-body p-1">
          {!! str_replace(':link', config('app.url'), __('errors.401.message')).'<br />' !!}
        </div>
      </div>
    </div>
  </div>
@endsection

@extends('app', ['disable_nav' => true])
@section('title', __('auth.registrationsubmitted'))

@section('content')
  <div class="clearfix" style="height: 30vh;"></div>
  <div class="row mt-2">
    <div col="col-lg-6 mx-auto content-center">
      <div class="card">
        <div class="card-body p-1">
          <h5 class="m-1">
            @lang('auth.registrationconfirmation')
            <i class="fas fa-check float-end"></i>
          </h5>
        </div>
        <div class="card-footer p-1 fw-bold">
          @lang('auth.confirmationmessage')
        </div>
      </div>
    </div>
  </div>
@endsection

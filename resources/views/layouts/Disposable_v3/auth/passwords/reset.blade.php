@extends('app', ['disable_nav' => true])
@section('title', __('Reset Password'))

@section('content')
  <div class="clearfix" style="height: 30vh;"></div>
  <div class="row mt-3">
    <div class="col-lg-6 mx-auto content-center">
      <div class="card mb-2">
        <div class="card-header p-1">
          <h5 class="m-1">
            {{ __('Reset Password') }}
            <i class="fas fa-unlock-alt float-end"></i>
          </h5>
        </div>
        <form class="form form-group" method="post" action="{{ url('/password/reset') }}">
          @csrf
          <input type="hidden" name="token" value="{{ $token }}"/>
          <div class="card-body p-1">
            @if($errors->any())
              {!! implode('', $errors->all('<div class="alert alert-danger mb-1 p-1 px-2 fw-bold">:message</div>')) !!}
            @endif
            <div class="input-group input-group-sm my-2">
              <span class="input-group-text col-lg-2">{{ __('Email Address') }}</span>
              <input class="form-control" type="email" name="email" id="email" value="{{ $email ?? old('email') }}" required />
            </div>
            <div class="input-group input-group-sm my-2">
              <span class="input-group-text col-lg-2">{{ __('Password') }}</span>
              <input class="form-control" type="password" name="password" id="password" required />
            </div>
            <div class="input-group input-group-sm my-2">
              <span class="input-group-text col-lg-2">{{ __('Confirm Password') }}</span>
              <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" required />
            </div>
          </div>
          <div class="card-footer p-1 d-grid">
            <button class="btn btn-primary btn-sm" type="submit">{{ __('Reset Password') }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

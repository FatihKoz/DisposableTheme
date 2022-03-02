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
        {{ Form::open(['url' => url('/password/email'), 'method' => 'post', 'role' => 'form', 'class' => 'form-group'])}}
          <div class="card-body p-1">
            @if(session('status'))
              <div class="alert alert-success p-1 px-2 fw-bold">{{ session('status') }}</div>
            @endif
            @if($errors->any())
              {!! implode('', $errors->all('<div class="alert alert-danger mb-1 p-1 px-2 fw-bold">:message</div>')) !!}
            @endif

            <div class="input-group input-group-sm my-2 {{ $errors->has('email') ? ' has-error' : '' }}">
              <span class="input-group-text col-lg-2" id="email">{{ __('Email Address') }}</span>
              <input
                class="form-control" name="email" type="email" aria-label="email" aria-describedby="email"
                placeholder="Provide the email address used for {{ config('app.name') }} registration" value="{{ old('email') }}"
                required
              />
            </div>
          </div>
          <div class="card-footer p-1 d-grid">
            <button type="submit" class="btn btn-primary btn-sm">{{ __('Send Password Reset Link') }}</button>
          </div>
        {{ Form::close() }}
      </div>
    </div>
  </div>
@endsection

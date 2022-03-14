@extends('app')
@section('title', __('profile.editprofile'))

@section('content')
  <div class="row">
    <div class="col-lg-7 mx-auto">
      <div class="card mb-2">
        <div class="card-header p-1">
          <h5 class="m-1">
            @lang('profile.edityourprofile')
            <i class="fas fa-user-alt float-end"></i>
          </h5>
        </div>
        {{ Form::model($user, ['route' => ['frontend.profile.update', $user->id], 'files' => true, 'method' => 'patch']) }}
        <div class="card-body p-1">
          @include("profile.fields")
        </div>
        {{-- Validation Responses --}}
        @if($errors->any())
          <div class="card-footer p-1">
            {!! implode('', $errors->all('<div class="alert alert-danger mb-1 p-1 px-2 fw-bold">:message</div>')) !!}
          </div>
        @endif
        <div class="card-footer p-1 text-end">
          {{ Form::submit(__('profile.updateprofile'), ['class' => 'btn btn-sm btn-primary m-0 mx-1 p-0 px-1']) }}
        </div>
        {{ Form::close() }}
      </div>
    </div>
  </div>
@endsection
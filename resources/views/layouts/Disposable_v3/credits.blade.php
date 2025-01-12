@extends('app')
@section('title', 'phpVMS v7 Credits')
@section('content')
  <div class="row row-cols-2">
    <div class="col-sm-5">
      <div class="card">
        <div class="card-header p-1">
          <h5 class="m-1">PHPVMS v7</h5>
        </div>
        <div class="card-body p-1">
          <img src="{{ public_asset('/assets/img/logo_blue_bg.svg') }}" width="100%" alt=""/>
          <p class="description">Open-Source Virtual Airline Management</p>
        </div>
        <div class="card-footer text-start p-1">
          <a href="https://docs.phpvms.net" target="_blank" class="btn btn-sm btn-primary">Documents & Guides</a>
          <a href="https://docs.phpvms.net/#license" target="_blank" class="btn btn-sm btn-primary">License</a>
        </div>
      </div>
    </div>
    <div class="col-sm-7">
      @foreach($modules as $module)
        <div class="card mb-2">
          <div class="card-header p-1">
            <h5 class="m-1">{{ $module->name }}</h5>
          </div>
          <div class="card-body p-1">
            <p class="description">{{ $module->description }}</p>
            @if($module->version)
              <p class="description">Version: {{ $module->version }}</p>
            @endif
          </div>
          <div class="card-footer text-start p-1">
            @if($module->active)
              <span class="text-success"><i class="fas fa-check-circle m-1" title="Active"></i></span>
            @else
              <span class="text-danger"><i class="fas fa-times-circle m-1" title="Not Active"></i></span>
            @endif
            <span class="float-end">
              @if($module->attribution)
                <a href="{{ $module->attribution->url }}" target="_blank" class="btn btn-sm btn-primary mx-1 p-0 px-1 mt-1">{{ $module->attribution->text }}</a>
              @endif
              @if($module->readme_url)
                <a href="{{ $module->readme_url }}" target="_blank" class="btn btn-sm btn-secondary mx-1 p-0 px-1 mt-1 text-black">Readme</a>
              @endif
              @if($module->license_url)
                <a href="{{ $module->license_url }}" target="_blank" class="btn btn-sm btn-secondary mx-1 p-0 px-1 mt-1 text-black">License</a>
              @endif
            </span>
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection

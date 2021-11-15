@extends('app')
@section('title', $page->name)

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card mb-2">
        <div class="card-header p-1">
          <h5 class="m-1">
            {{ $page->name }}
            <i class="fas fa-file-alt float-end"></i>
          </h5>
        </div>
        <div class="card-body p-1">
          {!! $page->body !!}
        </div>
        <div class="card-footer p-0 px-1 small text-end fw-bold">
          {{ $page->updated_at->format('d.M.Y H:i') }}
        </div>
      </div>
    </div>
  </div>
@endsection

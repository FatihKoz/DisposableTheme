@extends('app')
@section('title', trans_choice('common.download', 2))

@section('content')
  @if(!$grouped_files || count($grouped_files) === 0)
    <div class="alert alert-info mb-1 p-1 px-2 fw-bold">@lang('downloads.none')</div>
  @else
    <div class="nav nav-pills nav-justified mb-3" id="pills-tab" role="tablist">
      {{-- Inner Navigation --}}
      <button class="nav-link mx-1 p-1 active" id="airline-tab" data-bs-toggle="pill" data-bs-target="#airline" type="button" role="tab" aria-controls="airline" aria-selected="true">
        @lang('common.airline')
      </button>
      <button class="nav-link mx-1 p-1" id="airport-tab" data-bs-toggle="pill" data-bs-target="#airport" type="button" role="tab" aria-controls="airport" aria-selected="false">
        @lang('disposable.airport')
      </button>
      <button class="nav-link mx-1 p-1" id="subfleet-tab" data-bs-toggle="pill" data-bs-target="#subfleet" type="button" role="tab" aria-controls="subfleet" aria-selected="false">
        @lang('common.subfleet')
      </button>
      <button class="nav-link mx-1 p-1" id="aircraft-tab" data-bs-toggle="pill" data-bs-target="#aircraft" type="button" role="tab" aria-controls="aircraft" aria-selected="false">
        @lang('common.aircraft')
      </button>
    </div>
    <div class="tab-content" id="pills-tabContent">
      {{-- Airline & Acars Client Downloads --}}
      <div class="tab-pane fade show active" id="airline" role="tabpanel" aria-labelledby="airline-tab">
        <div id="DownloadsAirline" class="row row-cols-md-2 row-cols-lg-3">
          @foreach($grouped_files as $group => $files)
            @if(str_contains($group, 'ACARS'))
              @include('downloads.card')
            @endif
            @if(str_contains($group, 'Airline >'))
              @include('downloads.card', ['substr' => 10])
            @endif
          @endforeach
        </div>
      </div>
      {{-- Airport Downloads --}}
      <div class="tab-pane fade" id="airport" role="tabpanel" aria-labelledby="airport-tab">
        <div id="DownloadsAirport" class="row row-cols-md-2 row-cols-lg-3">
          @foreach($grouped_files as $group => $files)
            @if(str_contains($group, 'Airport >'))
              @include('downloads.card', ['substr' => 10])
            @endif
          @endforeach
        </div>
      </div>
      {{-- Subfleet Downloads --}}
      <div class="tab-pane fade" id="subfleet" role="tabpanel" aria-labelledby="subfleet-tab">
        <div id="DownloadsSubfleet" class="row row-cols-md-2 row-cols-lg-3">
          @foreach($grouped_files as $group => $files)
            @if(str_contains($group, 'Subfleet >'))
              @include('downloads.card', ['substr' => 11])
            @endif
          @endforeach
        </div>
      </div>
      {{-- Aircraft Downloads --}}
      <div class="tab-pane fade" id="aircraft" role="tabpanel" aria-labelledby="aircraft-tab">
        <div id="DownloadsAircraft" class="row row-cols-md-2 row-cols-lg-3">
          @foreach($grouped_files as $group => $files)
            @if(str_contains($group, 'Aircraft >'))
              @include('downloads.card', ['substr' => 11])
            @endif
          @endforeach
        </div>
      </div>
    </div>
  @endif
@endsection
@extends('app')
@section('title', trans_choice('common.download', 2))

@section('content')
  @if(!$grouped_files || count($grouped_files) === 0)
    <div class="alert alert-info mb-1 p-1 px-2 fw-bold">@lang('downloads.none')</div>
  @else
    {{-- Inner Navigation --}}
    <div class="nav nav-pills nav-justified mb-3" id="pills-tab" role="tablist">
      <button class="nav-link mx-1 p-1" id="aircraft-tab" data-bs-toggle="pill" data-bs-target="#aircraft" type="button" role="tab" aria-controls="aircraft" aria-selected="false">
        @lang('common.aircraft')
      </button>
      <button class="nav-link mx-1 p-1" id="subfleet-tab" data-bs-toggle="pill" data-bs-target="#subfleet" type="button" role="tab" aria-controls="subfleet" aria-selected="false">
        @lang('common.subfleet')
      </button>
      <button class="nav-link mx-1 p-1" id="airport-tab" data-bs-toggle="pill" data-bs-target="#airport" type="button" role="tab" aria-controls="airport" aria-selected="false">
        @lang('disposable.airport')
      </button>
      <button class="nav-link mx-1 p-1 active" id="airline-tab" data-bs-toggle="pill" data-bs-target="#airline" type="button" role="tab" aria-controls="airline" aria-selected="true">
        @lang('common.airline')
      </button>
    </div>
    {{-- Aircraft Downloads --}}
    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade" id="aircraft" role="tabpanel" aria-labelledby="aircraft-tab">
        <div id="DownloadsAircraft" class="row row-cols-3">
          @foreach($grouped_files as $group => $files)
            @if(strpos($group, 'Aircraft >') !== false)
              @include('downloads.card', ['substr' => 11])
            @endif
          @endforeach
        </div>
      </div>
      {{-- Subfleet Downloads --}}
      <div class="tab-pane fade" id="subfleet" role="tabpanel" aria-labelledby="subfleet-tab">
        <div id="DownloadsSubfleet" class="row row-cols-3">
          @foreach($grouped_files as $group => $files)
            @if(strpos($group, 'Subfleet >') !== false)
              @include('downloads.card', ['substr' => 11])
            @endif
          @endforeach
        </div>
      </div>
      {{-- Airport Downloads --}}
      <div class="tab-pane fade" id="airport" role="tabpanel" aria-labelledby="airport-tab">
        <div id="DownloadsAirport" class="row row-cols-3">
          @foreach($grouped_files as $group => $files)
            @if(strpos($group, 'Airport >') !== false)
              @include('downloads.card', ['substr' => 10])
            @endif
          @endforeach
        </div>
      </div>
      {{-- Airline Downloads --}}
      <div class="tab-pane fade show active" id="airline" role="tabpanel" aria-labelledby="airline-tab">
        <div id="DownloadsAirline" class="row row-cols-3">
          @foreach($grouped_files as $group => $files)
            @if(strpos($group, 'Airline >') !== false)
              @include('downloads.card', ['substr' => 10])
            @endif
          @endforeach
        </div>
      </div>
    </div>
  @endif
@endsection
@if($news->count() > 0)
  @php 
    $DBasic = isset($DBasic) ? $DBasic : check_module('DisposableBasic'); 
  @endphp
  <div class="card mb-2">
    <div class="card-header p-1">
      <h5 class="m-1">
        @lang('widgets.latestnews.news')
        @if($news->count() > 1)
          <i class="fas fa-scroll float-end" title="Show More" data-toggle="collapse" data-target="#news" aria-expanded="false" aria-controls="news"></i>
        @else
          <i class="fas fa-book-reader float-end"></i>
        @endif
      </h5>
    </div>
    <div class="card-body p-1">
      @foreach($news as $item)
        @if($loop->iteration === 2)
          <div class="collapse" id="news">
        @endif
        @if(!$loop->first)
          <hr class="m-0 p-0">
        @endif
          <div class="row">
            <div class="col">
              <h5 class="my-1">{{ $item->subject }}</h5>
            </div>
          </div>
          <div class="row">
            <div class="col">
              {!! $item->body !!}
            </div>
          </div>
          <div class="row">
            <div class="col text-end small">
             {{ optional($item->user)->name_private }} @ <b>{{ $item->created_at->format('l d.M.Y H:i') }}</b>
            </div>
          </div>
        @if($loop->iteration > 1 && $loop->last)
          </div>
        @endif
      @endforeach
    </div>
    <div class="card-footer p-0 px-1 small text-end fw-bold">
      @if($DBasic)
        <a class="float-start" href="{{ route('DBasic.news') }}">@lang('disposable.all')</a>
      @endif
      @lang('disposable.latest') {{ $news->count() }}
    </div>
  </div>
@endif
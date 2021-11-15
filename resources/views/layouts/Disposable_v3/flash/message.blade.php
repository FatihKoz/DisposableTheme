@foreach(collect(session('flash_notification', collect()))->toArray() as $message)
  @if(is_string($message))
    <div class="alert alert-danger mb-2 p-1 px-2 fw-bold">
      {!! $message !!}
    </div>
  @else
    @if($message['overlay'])
      @include('flash.modal', ['modalClass' => 'flash-modal', 'title' => $message['title'], 'body' => $message['message']])
    @else
      <div class="alert mb-2 p-1 px-1 fw-bold alert-{{ $message['level'] }} {{ $message['important'] ? 'alert-important' : '' }}" role="alert">
        @if($message['important'])
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        @endif
        {!! $message['message'] !!}
      </div>
    @endif
  @endif
@endforeach
{{ session()->forget('flash_notification') }}